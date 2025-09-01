<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class QuestionsTemplateExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * Mendefinisikan judul (header) untuk setiap kolom di file Excel.
     * Nama-nama ini harus sama persis dengan yang diharapkan oleh QuestionsImport.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'section',
            'part',
            'question_text',
            'choice_a',
            'choice_b',
            'choice_c',
            'choice_d',
            'correct_answer',
            'audio_file_name',
            'reading_passage_title',
            'reading_passage_text',
        ];
    }

    /**
     * Menyiapkan data contoh untuk dimasukkan ke dalam template.
     * Ini akan sangat membantu admin memahami cara mengisi file.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return new Collection([
            [
                'section' => 'listening',
                'part' => 'A',
                'question_text' => 'What does the woman mean?',
                'choice_a' => 'She will go to the party.',
                'choice_b' => 'She doesn\'t like parties.',
                'choice_c' => 'She has to study for a test.',
                'choice_d' => 'She will meet the man later.',
                'correct_answer' => 'C',
                'audio_file_name' => 'audio_01.mp3',
                'reading_passage_title' => '',
                'reading_passage_text' => '',
            ],
            [
                'section' => 'structure',
                'part' => 'B',
                'question_text' => 'The committee members ________ their decision until the next meeting.',
                'choice_a' => 'are postponing',
                'choice_b' => 'postponed',
                'choice_c' => 'will postpone',
                'choice_d' => 'postpone',
                'correct_answer' => 'C',
                'audio_file_name' => '',
                'reading_passage_title' => '',
                'reading_passage_text' => '',
            ],
            [
                'section' => 'reading',
                'part' => 'Passage 1',
                'question_text' => 'What is the main purpose of the passage?',
                'choice_a' => 'To describe the planets.',
                'choice_b' => 'To explain the history of astronomy.',
                'choice_c' => 'To discuss the possibility of alien life.',
                'choice_d' => 'To compare two different theories.',
                'correct_answer' => 'B',
                'audio_file_name' => '',
                'reading_passage_title' => 'The History of Astronomy',
                'reading_passage_text' => 'Astronomy is one of the oldest natural sciences. Early civilizations performed methodical observations of the night sky... (lanjutkan teks lengkap di sini)',
            ],
            [
                'section' => 'reading',
                'part' => 'Passage 1',
                'question_text' => 'The word "methodical" in line 2 is closest in meaning to...',
                'choice_a' => 'systematic',
                'choice_b' => 'accidental',
                'choice_c' => 'quick',
                'choice_d' => 'scientific',
                'correct_answer' => 'A',
                'audio_file_name' => '',
                'reading_passage_title' => '',
                'reading_passage_text' => '',
            ],
        ]);
    }
}
