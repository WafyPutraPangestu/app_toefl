<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\TestPackage;
use App\Models\TestSession;
use App\Models\UserAnswer;
use App\Services\ToeflScoreConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TestController extends Controller
{
    /**
     * 1. Menampilkan Dashboard Peserta
     */
    public function dashboard()
    {
        $user = Auth::user();
        $testPackages = TestPackage::withCount('questions')->get();

        // Ambil SEMUA riwayat tes user, diurutkan dari yang terbaru
        $testHistory = TestSession::where('user_id', $user->id)
            ->with(['testPackage', 'result'])
            ->latest()
            ->get();

        // Pastikan hanya mengirim $testHistory yang berisi SEMUA data riwayat.
        return view('user.dashboard', compact('testPackages', 'testHistory'));
    }

    /**
     * 2. Memulai Sesi Tes
     * Membuat record TestSession dan mengarahkan ke soal pertama.
     */
    public function start(TestPackage $testPackage)
    {
        // Cek jika user sudah punya sesi yang 'in_progress'
        $existingSession = TestSession::where('user_id', Auth::id())
            ->where('status', 'in_progress')
            ->first();

        if ($existingSession) {
            // Jika ada, arahkan kembali ke sesi yang sedang berjalan
            $firstQuestionId = $existingSession->testPackage->questions()->orderBy('id')->first()->id;
            return redirect()->route('user.test.show', ['session' => $existingSession->id, 'question' => $firstQuestionId])
                ->with('warning', 'Anda sudah memiliki sesi tes yang sedang berjalan. Silakan selesaikan terlebih dahulu.');
        }

        // Mulai transaksi database untuk memastikan konsistensi data
        $session = DB::transaction(function () use ($testPackage) {
            return TestSession::create([
                'user_id' => Auth::id(),
                'test_package_id' => $testPackage->id,
                'start_time' => now(),
                'status' => 'in_progress',
            ]);
        });

        // Ambil soal pertama dari paket tes
        $firstQuestion = $testPackage->questions()->orderBy('id')->first();

        if (!$firstQuestion) {
            return redirect()->route('user.dashboard')->with('error', 'Paket tes ini tidak memiliki soal.');
        }

        // Arahkan user ke halaman soal pertama
        return redirect()->route('user.test.show', ['session' => $session->id, 'question' => $firstQuestion->id]);
    }


    /**
     * 3. Menampilkan Halaman Pengerjaan Soal
     * Menampilkan satu soal beserta navigasi.
     */
    public function showQuestion(TestSession $session, Question $question)
    {
        // Pastikan user hanya bisa mengakses sesi miliknya
        if ($session->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Pastikan sesi masih berjalan
        if ($session->status !== 'in_progress') {
            return redirect()->route('user.test.result', $session)->with('info', 'Sesi tes ini telah selesai.');
        }

        // Load relasi yang dibutuhkan
        $session->load('testPackage.questions');
        $question->load(['choices', 'readingPassage']);

        // Ambil semua soal dari paket untuk navigasi sidebar
        $allQuestions = $session->testPackage->questions()->orderBy('id')->get();

        // Ambil ID soal yang sudah dijawab user di sesi ini
        $answeredQuestionIds = $session->userAnswers()->pluck('question_id')->toArray();

        // Ambil jawaban user untuk soal saat ini (jika ada)
        $currentAnswer = $session->userAnswers()->where('question_id', $question->id)->first();

        // Hitung waktu selesai
        $endTime = Carbon::parse($session->start_time)->addMinutes($session->testPackage->duration_minutes);

        return view('user.test.show', compact(
            'session',
            'question',
            'allQuestions',
            'answeredQuestionIds',
            'currentAnswer',
            'endTime'
        ));
    }

    /**
     * 4. Menyimpan Jawaban User
     * Menggunakan updateOrCreate untuk menyimpan atau memperbarui jawaban.
     */
    public function storeAnswer(Request $request, TestSession $session, Question $question)
    {
        // Validasi
        $request->validate(['selected_choice_id' => 'required|exists:question_choices,id']);

        // Pastikan user hanya bisa mengakses sesi miliknya
        if ($session->user_id !== Auth::id() || $session->status !== 'in_progress') {
            abort(403);
        }

        // Simpan atau perbarui jawaban user
        UserAnswer::updateOrCreate(
            [
                'test_session_id' => $session->id,
                'question_id' => $question->id,
            ],
            [
                'selected_choice_id' => $request->selected_choice_id,
            ]
        );

        // Cari soal berikutnya
        $nextQuestion = Question::where('test_package_id', $session->test_package_id)
            ->where('id', '>', $question->id)
            ->orderBy('id')
            ->first();

        // Jika ada soal berikutnya, arahkan ke sana
        if ($nextQuestion) {
            return redirect()->route('user.test.show', [$session, $nextQuestion]);
        }

        // Jika ini adalah soal terakhir, kembali ke soal yang sama dengan pesan
        return redirect()->route('user.test.show', [$session, $question])
            ->with('success', 'Jawaban disimpan. Ini adalah soal terakhir. Klik "Selesai" jika Anda sudah yakin.');
    }


    /**
     * 5. Menyelesaikan Tes dan Menghitung Skor
     */
    public function finish(TestSession $session, ToeflScoreConverter $converter)
    {
        // Pastikan user hanya bisa mengakses sesi miliknya
        if ($session->user_id !== Auth::id() || $session->status !== 'in_progress') {
            abort(403);
        }

        DB::transaction(function () use ($session, $converter) {
            // 1. Update status sesi
            $session->update([
                'status' => 'completed',
                'end_time' => now()
            ]);

            // 2. Ambil semua pertanyaan dan jawaban
            $allQuestions = $session->testPackage->questions()->get();
            $userAnswers = $session->userAnswers()->with('selectedChoice')->get()->keyBy('question_id');

            // 3. Siapkan data untuk kalkulasi
            $sectionsData = [
                'listening' => ['correct' => 0, 'total' => 0],
                'structure' => ['correct' => 0, 'total' => 0],
                'reading'   => ['correct' => 0, 'total' => 0],
            ];

            foreach ($allQuestions as $q) {
                $section = $q->section; // 'listening', 'structure', atau 'reading'
                if (isset($sectionsData[$section])) {
                    $sectionsData[$section]['total']++;

                    // Cek jika user menjawab soal ini
                    if (isset($userAnswers[$q->id])) {
                        $answer = $userAnswers[$q->id];
                        // Cek jika jawaban benar
                        if ($answer->selectedChoice && $answer->selectedChoice->is_correct) {
                            $sectionsData[$section]['correct']++;
                        }
                    }
                }
            }

            // 4. Hitung skor menggunakan service
            $scores = $converter->calculate($sectionsData);

            // 5. Tentukan status LULUS / TIDAK LULUS
            $passing_score = $session->testPackage->passing_score;
            $status = ($scores['total_score'] >= $passing_score) ? 'LULUS' : 'TIDAK LULUS';

            // 6. Simpan hasil ke tabel test_results
            $session->result()->create([
                'score_listening' => $scores['score_listening'],
                'score_structure' => $scores['score_structure'],
                'score_reading'   => $scores['score_reading'],
                'total_score'     => $scores['total_score'],
                'status'          => $status,
                // certificate_id bisa di-generate nanti jika lulus
            ]);
        });

        return redirect()->route('user.test.result', $session)->with('success', 'Tes telah selesai!');
    }

    /**
     * 6. Menampilkan Halaman Hasil
     */
    public function showResult(TestSession $session)
    {
        // Pastikan user hanya bisa mengakses hasil tes miliknya
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        $session->load(['result', 'testPackage']);

        return view('user.test.result', compact('session'));
    }

    /**
     * 7. Mengajukan Permintaan Retake
     */
    public function requestRetake(TestSession $session)
    {
        // Pastikan user hanya bisa mengakses sesi miliknya
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya bisa request jika status 'completed' dan hasil 'TIDAK LULUS'
        // dan belum pernah request sebelumnya
        if ($session->status === 'completed' && optional($session->result)->status === 'TIDAK LULUS' && is_null($session->retake_requested_at)) {
            $session->update(['retake_requested_at' => now()]);
            return redirect()->route('user.dashboard')->with('success', 'Permintaan untuk mengerjakan ulang telah diajukan. Mohon tunggu persetujuan dari Admin.');
        }

        return redirect()->route('user.dashboard')->with('error', 'Anda tidak dapat mengajukan permintaan pengerjaan ulang untuk tes ini.');
    }
}
