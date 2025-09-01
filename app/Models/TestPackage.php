<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration_minutes',
        'passing_score',
        'created_by',
    ];

    // === RELASI ===

    /**
     * Relasi ke User (admin) yang membuat paket ini.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Satu paket tes memiliki banyak soal.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Satu paket tes bisa dikerjakan dalam banyak sesi ujian.
     */
    public function testSessions()
    {
        return $this->hasMany(TestSession::class);
    }
}
