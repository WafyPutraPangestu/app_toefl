<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\ReadingPassage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class QuestionsImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading
{
    protected int $testPackageId;
    private $readingPassages = []; // Cache untuk reading passages
    private $errors = []; // Collect errors untuk reporting

    public function __construct(int $testPackageId)
    {
        $this->testPackageId = $testPackageId;
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $index => $row) {
                try {
                    $this->processRow($row->toArray(), $index + 2); // +2 karena header row + 0-based index
                } catch (\Exception $e) {
                    $this->errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                    throw $e; // Re-throw untuk rollback transaction
                }
            }
        });

        // Jika ada error, lempar exception
        if (!empty($this->errors)) {
            throw new \Exception("Import gagal: " . implode('; ', $this->errors));
        }
    }

    private function processRow(array $row, int $rowNumber)
    {
        // Konversi section ke huruf kecil untuk konsistensi
        $section = strtolower($row['section']);

        // Handle Reading Passage
        $readingPassageId = null;
        if ($section == 'reading') {
            $readingPassageId = $this->handleReadingPassage($row, $rowNumber);
        }

        // Handle Audio File untuk Listening
        $audioFilePath = null;
        if ($section == 'listening' && !empty($row['audio_file_name'])) {
            $audioFilePath = $this->handleAudioFile($row['audio_file_name'], $rowNumber);
        }

        // Buat Question
        $question = Question::create([
            'test_package_id'    => $this->testPackageId,
            'section'            => $section,
            'part'               => $row['part'],
            'question_text'      => $row['question_text'],
            'audio_file_path'    => $audioFilePath,
            'reading_passage_id' => $readingPassageId,
        ]);

        // Buat Choices
        $this->createChoices($question, $row);
    }

    private function handleReadingPassage(array $row, int $rowNumber): ?int
    {
        // Jika ada teks passage baru, buat passage baru
        if (!empty($row['reading_passage_text'])) {
            $passageTitle = $row['reading_passage_title'] ?? 'Reading Passage ' . count($this->readingPassages) + 1;
            
            // Cek apakah passage dengan title yang sama sudah ada
            $existingPassage = collect($this->readingPassages)->first(function ($passage) use ($passageTitle) {
                return $passage['title'] === $passageTitle;
            });

            if ($existingPassage) {
                return $existingPassage['id'];
            }

            // Buat passage baru
            $passage = ReadingPassage::create([
                'test_package_id' => $this->testPackageId,
                'title' => $passageTitle,
                'passage_text' => $row['reading_passage_text'],
            ]);

            // Cache passage untuk digunakan selanjutnya
            $this->readingPassages[] = [
                'id' => $passage->id,
                'title' => $passageTitle
            ];

            return $passage->id;
        }

        // Jika tidak ada teks passage, gunakan passage terakhir yang dibuat
        if (!empty($this->readingPassages)) {
            return end($this->readingPassages)['id'];
        }

        throw new \Exception("Soal reading harus memiliki reading passage atau menggunakan passage sebelumnya");
    }

    private function handleAudioFile(string $audioFileName, int $rowNumber): string
    {
        // Path file audio di folder staging
        $stagingPath = 'import_audio/' . $audioFileName;
        
        // Cek apakah file exists di staging folder
        if (!Storage::disk('public')->exists($stagingPath)) {
            throw new \Exception("File audio '{$audioFileName}' tidak ditemukan. Pastikan file sudah di-upload ke folder import_audio");
        }

        // Path final untuk file audio
        $finalPath = 'audio_files/' . $audioFileName;

        // Copy file dari staging ke folder final
        $fileContent = Storage::disk('public')->get($stagingPath);
        Storage::disk('public')->put($finalPath, $fileContent);

        return $finalPath;
    }

    private function createChoices(Question $question, array $row): void
    {
        $choices = [
            'A' => $row['choice_a'], 
            'B' => $row['choice_b'], 
            'C' => $row['choice_c'], 
            'D' => $row['choice_d']
        ];

        $correctAnswer = strtoupper($row['correct_answer']);

        foreach ($choices as $key => $value) {
            QuestionChoice::create([
                'question_id' => $question->id,
                'choice_text' => $value,
                'is_correct'  => ($correctAnswer === $key),
            ]);
        }
    }

    /**
     * Aturan validasi untuk setiap baris di file Excel.
     */
    public function rules(): array
    {
        return [
            '*.section' => 'required|in:listening,structure,reading,Listening,Structure,Reading',
            '*.part' => 'required|string|max:50',
            '*.question_text' => 'required|string',
            '*.choice_a' => 'required|string',
            '*.choice_b' => 'required|string',
            '*.choice_c' => 'required|string',
            '*.choice_d' => 'required|string',
            '*.correct_answer' => 'required|in:A,B,C,D,a,b,c,d',

            // Validasi conditional untuk audio file
            '*.audio_file_name' => 'nullable|string|required_if:*.section,listening,Listening',
            
            // Kolom reading passage
            '*.reading_passage_title' => 'nullable|string|max:255',
            '*.reading_passage_text' => 'nullable|string',
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages(): array
    {
        return [
            '*.section.required' => 'Section harus diisi',
            '*.section.in' => 'Section harus listening, structure, atau reading',
            '*.audio_file_name.required_if' => 'File audio wajib untuk soal listening',
            '*.correct_answer.in' => 'Jawaban benar harus A, B, C, atau D',
        ];
    }

    /**
     * Membaca file Excel dalam potongan (chunk) untuk efisiensi memori.
     */
    public function chunkSize(): int
    {
        return 50; // Reduce chunk size untuk stability
    }

    /**
     * Get collected errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}