<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingPassage extends Model
{
    use HasFactory;

    protected $fillable = ['test_package_id', 'title', 'passage_text'];

    // === RELASI ===

    /**
     * Satu teks bacaan dimiliki oleh satu paket tes.
     */
    public function testPackage()
    {
        return $this->belongsTo(TestPackage::class);
    }

    /**
     * Satu teks bacaan bisa digunakan untuk banyak soal.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
