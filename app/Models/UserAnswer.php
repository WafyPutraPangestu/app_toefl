<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_session_id',
        'question_id',
        'selected_choice_id',
    ];

    // === RELASI ===

    public function testSession()
    {
        return $this->belongsTo(TestSession::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedChoice()
    {
        return $this->belongsTo(QuestionChoice::class, 'selected_choice_id');
    }
}
