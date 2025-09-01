<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_session_id',
        'score_listening',
        'score_structure',
        'score_reading',
        'total_score',
        'status',
        'certificate_id',
    ];

    // === RELASI ===

    public function testSession()
    {
        return $this->belongsTo(TestSession::class);
    }
}
