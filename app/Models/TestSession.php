<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_package_id',
        'start_time',
        'end_time',
        'retake_requested_at',
        'status',
        'retake_approved_at',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'retake_requested_at' => 'datetime',
        'retake_approved_at' => 'datetime',
    ];

    // === RELASI ===

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function testPackage()
    {
        return $this->belongsTo(TestPackage::class);
    }

    /**
     * Satu sesi ujian memiliki banyak jawaban dari user.
     */
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    /**
     * Satu sesi ujian akan menghasilkan satu record hasil.
     */
    public function result()
    {
        return $this->hasOne(TestResult::class);
    }
}
