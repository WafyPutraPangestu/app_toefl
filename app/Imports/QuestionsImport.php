<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\ReadingPassage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class QuestionsImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading
{
    protected int $testPackageId;
    private $lastReadingPassageId = null;

    public function __construct(int $testPackageId)
    {
        $this->testPackageId = $testPackageId;
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // Konversi section ke huruf kecil untuk konsistensi
                $section = strtolower($row['section']);

                // Langkah 1: Cek apakah ini baris untuk membuat Reading Passage baru
                if ($section == 'reading' && !empty($row['reading_passage_text'])) {
                    $passage = ReadingPassage::create([
                        'test_package_id' => $this->testPackageId,
                        'title' => $row['reading_passage_title'] ?? 'Reading Passage', // Ambil judul, atau gunakan default
                        'passage_text' => $row['reading_passage_text'],
                    ]);
                    // Simpan ID passage ini untuk digunakan oleh soal-soal berikutnya
                    $this->lastReadingPassageId = $passage->id;
                }

                // Langkah 2: Buat Soal (Question)
                $question = Question::create([
                    'test_package_id'    => $this->testPackageId,
                    'section'            => $section,
                    'part'               => $row['part'],
                    'question_text'      => $row['question_text'],
                    'audio_file_path'    => $row['audio_file_name'] ?? null,
                    'reading_passage_id' => ($section == 'reading') ? $this->lastReadingPassageId : null,
                ]);

                // Langkah 3: Buat Pilihan Jawaban (QuestionChoice)
                $choices = ['A' => $row['choice_a'], 'B' => $row['choice_b'], 'C' => $row['choice_c'], 'D' => $row['choice_d']];
                foreach ($choices as $key => $value) {
                    QuestionChoice::create([
                        'question_id' => $question->id,
                        'choice_text' => $value,
                        'is_correct'  => (strtoupper($row['correct_answer']) == $key),
                    ]);
                }
            }
        });
    }

    /**
     * Aturan validasi untuk setiap baris di file Excel.
     */
    public function rules(): array
    {
        return [
            // Tanda '*' berarti aturan ini berlaku untuk setiap baris
            '*.section' => 'required|in:listening,structure,reading,Listening,Structure,Reading',
            '*.part' => 'required|string',
            '*.question_text' => 'required|string',
            '*.choice_a' => 'required|string',
            '*.choice_b' => 'required|string',
            '*.choice_c' => 'required|string',
            '*.choice_d' => 'required|string',
            '*.correct_answer' => 'required|in:A,B,C,D,a,b,c,d',

            // Kolom-kolom ini boleh kosong (nullable)
            '*.audio_file_name' => 'nullable|string',
            '*.reading_passage_title' => 'nullable|string',
            '*.reading_passage_text' => 'nullable|string',
        ];
    }

    /**
     * Membaca file Excel dalam potongan (chunk) untuk efisiensi memori.
     */
    public function chunkSize(): int
    {
        return 100; // Proses 100 baris sekali jalan
    }
}
