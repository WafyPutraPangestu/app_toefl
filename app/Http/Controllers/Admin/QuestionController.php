<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuestionsTemplateExport;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\TestPackage;
use App\Models\ReadingPassage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $query = Question::with(['testPackage', 'readingPassage'])->latest();

        if ($request->filled('test_package_id')) {
            $query->where('test_package_id', $request->test_package_id);
        }
        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }
        if ($request->filled('part')) {
            $query->where('part', 'like', '%' . $request->part . '%');
        }
        if ($request->filled('search')) {
            $query->where('question_text', 'like', '%' . $request->search . '%');
        }

        $questions = $query->paginate(10)->withQueryString();
        $testPackages = TestPackage::orderBy('title')->get();

        return view('admin.questions.index', compact('questions', 'testPackages'));
    }

    public function create()
    {
        $testPackages = TestPackage::orderBy('title')->get();
        $readingPassages = ReadingPassage::select('id', 'title', 'test_package_id')->orderBy('title')->get();
        return view('admin.questions.create', compact('testPackages', 'readingPassages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'test_package_id' => 'required|exists:test_packages,id',
            'section' => 'required|in:listening,structure,reading',
            'part' => 'required|string|max:50',
            'question_text' => 'required|string',
            'audio_file' => 'nullable|required_if:section,listening|file|mimes:mp3,wav,ogg|max:10240',
            'reading_passage_id' => 'required_if:section,reading|nullable|exists:reading_passages,id',
            'choices' => 'required|array|min:4',
            'choices.A' => 'required|string',
            'choices.B' => 'required|string',
            'choices.C' => 'required|string',
            'choices.D' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $audioPath = null;
        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('audio_files', 'public');
        }

        DB::transaction(function () use ($request, $audioPath) {
            $question = Question::create([
                'test_package_id' => $request->test_package_id,
                'section' => $request->section,
                'part' => $request->part,
                'question_text' => $request->question_text,
                'audio_file_path' => $audioPath,
                'reading_passage_id' => $request->section === 'reading' ? $request->reading_passage_id : null,
            ]);

            foreach ($request->choices as $key => $choiceText) {
                $question->choices()->create([
                    'choice_text' => $choiceText,
                    'is_correct' => ($key == $request->correct_answer),
                ]);
            }
        });

        return redirect()->route('questions.index')->with('success', 'Soal berhasil dibuat.');
    }

    public function show(Question $question)
    {
        $question->load(['testPackage', 'choices', 'readingPassage']);
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $question->load('choices');
        $testPackages = TestPackage::orderBy('title')->get();
        $readingPassages = ReadingPassage::select('id', 'title', 'test_package_id')->orderBy('title')->get();

        return view('admin.questions.edit', compact('question', 'testPackages', 'readingPassages'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'test_package_id' => 'required|exists:test_packages,id',
            'section' => 'required|in:listening,structure,reading',
            'part' => 'required|string|max:50',
            'question_text' => 'required|string',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'reading_passage_id' => 'required_if:section,reading|nullable|exists:reading_passages,id',
            'choices' => 'required|array|min:4',
            'choices.*' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $audioPath = $question->audio_file_path;
        if ($request->hasFile('audio_file') && $request->section == 'listening') {
            if ($question->audio_file_path) {
                Storage::disk('public')->delete($question->audio_file_path);
            }
            $audioPath = $request->file('audio_file')->store('audio_files', 'public');
        }

        DB::transaction(function () use ($request, $question, $audioPath) {
            $question->update([
                'test_package_id' => $request->test_package_id,
                'section' => $request->section,
                'part' => $request->part,
                'question_text' => $request->question_text,
                'audio_file_path' => $audioPath,
                'reading_passage_id' => $request->section === 'reading' ? $request->reading_passage_id : null,
            ]);

            $question->choices()->delete();
            foreach ($request->choices as $key => $choiceText) {
                $question->choices()->create([
                    'choice_text' => $choiceText,
                    'is_correct' => ($key == $request->correct_answer),
                ]);
            }
        });

        return redirect()->route('questions.index')->with('success', 'Soal berhasil diupdate.');
    }

    public function destroy(Question $question)
    {
        DB::transaction(function () use ($question) {
            if ($question->audio_file_path) {
                Storage::disk('public')->delete($question->audio_file_path);
            }
            $question->choices()->delete();
            $question->delete();
        });

        return back()->with('success', 'Soal berhasil dihapus.');
    }

    /**
     * [DITAMBAHKAN KEMBALI] Method untuk menangani import dari Excel.
     */
 // app/Http/Controllers/Admin/QuestionController.php

/**
 * [MODIFIKASI TOTAL] Method untuk menangani import dari Excel dan mengembalikan JSON.
 */
public function importStore(Request $request)
{
    $request->validate([
        'test_package_id' => 'required|exists:test_packages,id',
        'file_soal' => 'required|mimes:xlsx,csv',
    ]);

    try {
        Excel::import(new QuestionsImport($request->test_package_id), $request->file('file_soal'));
        
        // Jika sukses, kembalikan JSON sukses
        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil diimpor. Halaman akan dimuat ulang.'
        ]);

    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        // Jika ada error validasi dari file Excel itu sendiri
        return response()->json([
            'success' => false, 
            'message' => 'Terdapat kesalahan pada file Excel Anda.',
            'errors' => $e->failures()
        ], 422); // Status 422: Unprocessable Entity

    } catch (\Throwable $e) {
        // Jika ada error lain (seperti file audio tidak ditemukan)
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat import: ' . $e->getMessage()
        ], 500); // Status 500: Internal Server Error
    }
}

    /**
     * [DITAMBAHKAN KEMBALI] Method untuk men-download file template Excel.
     */
    public function downloadTemplate()
    {
        // dd('Download template not implemented yet.'); // Placeholder for actual implementation
        return Excel::download(new QuestionsTemplateExport, 'template_import_soal.xlsx');
    }
 /**
 * Method untuk QuestionController.php - JSON Response Version
 */

/**
 * Get daftar file audio yang sudah ada (untuk AJAX)
 */
public function getAudioFiles()
{
    try {
        // Ambil daftar file audio yang sudah ada di folder import_audio
        $existingAudioFiles = collect(Storage::disk('public')->files('import_audio'))
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'size' => Storage::disk('public')->size($file),
                    'size_formatted' => $this->formatBytes(Storage::disk('public')->size($file)),
                    'uploaded_at' => Storage::disk('public')->lastModified($file),
                    'uploaded_at_formatted' => date('d/m/Y H:i', Storage::disk('public')->lastModified($file)),
                ];
            })
            ->sortByDesc('uploaded_at')
            ->values();

        return response()->json([
            'success' => true,
            'data' => $existingAudioFiles
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengambil daftar file audio: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Handle upload audio batch (JSON Response)
 */
public function uploadAudioBatch(Request $request)
{
    $request->validate([
        'audio_files' => 'required|array|min:1',
        'audio_files.*' => 'required|file|mimes:mp3,wav,ogg|max:10240', // 10MB max per file
    ]);

    $uploadedFiles = [];
    $errors = [];

    foreach ($request->file('audio_files') as $file) {
        try {
            $originalName = $file->getClientOriginalName();
            
            // Cek jika file sudah ada
            if (Storage::disk('public')->exists('import_audio/' . $originalName)) {
                $errors[] = "File '{$originalName}' sudah ada. Gunakan nama yang berbeda.";
                continue;
            }

            // Upload file ke folder import_audio
            $path = $file->storeAs('import_audio', $originalName, 'public');
            $uploadedFiles[] = [
                'name' => $originalName,
                'path' => $path,
                'size' => $file->getSize(),
                'size_formatted' => $this->formatBytes($file->getSize())
            ];

        } catch (\Exception $e) {
            $errors[] = "Gagal upload '{$file->getClientOriginalName()}': " . $e->getMessage();
        }
    }

    $successCount = count($uploadedFiles);
    $errorCount = count($errors);

    return response()->json([
        'success' => $successCount > 0,
        'message' => "{$successCount} file audio berhasil di-upload." . 
                    ($errorCount > 0 ? " {$errorCount} file gagal di-upload." : ""),
        'data' => [
            'uploaded_files' => $uploadedFiles,
            'errors' => $errors,
            'success_count' => $successCount,
            'error_count' => $errorCount
        ]
    ], $successCount > 0 ? 200 : 422);
}

/**
 * Delete audio file dari staging folder (JSON Response)
 */
public function deleteAudioFile(Request $request)
{
    $request->validate([
        'filename' => 'required|string'
    ]);

    $filename = $request->filename;
    $filePath = 'import_audio/' . $filename;

    if (!Storage::disk('public')->exists($filePath)) {
        return response()->json([
            'success' => false,
            'message' => 'File tidak ditemukan'
        ], 404);
    }

    try {
        Storage::disk('public')->delete($filePath);
        return response()->json([
            'success' => true,
            'message' => 'File berhasil dihapus',
            'data' => [
                'filename' => $filename
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus file: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Cleanup unused audio files (JSON Response)
 */
public function cleanupAudioFiles()
{
    try {
        // Ambil semua file audio di staging
        $stagingFiles = collect(Storage::disk('public')->files('import_audio'))
            ->map(fn($file) => basename($file));

        // Ambil semua audio yang digunakan di questions
        $usedAudioFiles = Question::whereNotNull('audio_file_path')
            ->pluck('audio_file_path')
            ->map(fn($path) => basename($path))
            ->unique();

        // Find unused files di staging (yang sudah lebih dari 7 hari dan tidak digunakan)
        $unusedFiles = $stagingFiles->reject(function ($file) use ($usedAudioFiles) {
            $filePath = 'import_audio/' . $file;
            $lastModified = Storage::disk('public')->lastModified($filePath);
            $isOld = (time() - $lastModified) > (7 * 24 * 60 * 60); // 7 hari
            $isUsed = $usedAudioFiles->contains($file);

            return $isUsed || !$isOld;
        });

        // Delete unused files
        $deletedFiles = [];
        foreach ($unusedFiles as $file) {
            Storage::disk('public')->delete('import_audio/' . $file);
            $deletedFiles[] = $file;
        }

        $deletedCount = count($deletedFiles);

        return response()->json([
            'success' => true,
            'message' => "{$deletedCount} file audio tidak terpakai berhasil dibersihkan.",
            'data' => [
                'deleted_files' => $deletedFiles,
                'deleted_count' => $deletedCount
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal membersihkan file audio: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Helper method untuk format ukuran file
 */
private function formatBytes($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    for ($i = 0; $bytes > 1024; $i++) {
        $bytes /= 1024;
    }

    return round($bytes, $precision) . ' ' . $units[$i];
}
}
