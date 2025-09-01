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
    public function importStore(Request $request)
    {
        $request->validate([
            'test_package_id' => 'required|exists:test_packages,id',
            'file_soal' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new QuestionsImport($request->test_package_id), $request->file('file_soal'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return back()->with('import_errors', $failures);
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }

        return redirect()->route('questions.index')->with('success', 'Soal berhasil diimpor.');
    }

    /**
     * [DITAMBAHKAN KEMBALI] Method untuk men-download file template Excel.
     */
    public function downloadTemplate()
    {
        // dd('Download template not implemented yet.'); // Placeholder for actual implementation
        return Excel::download(new QuestionsTemplateExport, 'template_import_soal.xlsx');
    }
}
