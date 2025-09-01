<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_package_id',
        'section',
        'part',
        'question_text',
        'audio_file_path',
        'reading_passage_id',
    ];

    // === RELASI ===

    public function testPackage()
    {
        return $this->belongsTo(TestPackage::class);
    }

    public function readingPassage()
    {
        return $this->belongsTo(ReadingPassage::class);
    }

    /**
     * Satu soal memiliki banyak pilihan jawaban.
     */
    public function choices()
    {
        return $this->hasMany(QuestionChoice::class);
    }
}
