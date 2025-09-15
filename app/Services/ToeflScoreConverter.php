<?php

namespace App\Services;

/**
 * Class ini bertanggung jawab untuk menghitung skor tes sesuai standar TOEFL ITP (PBT).
 * Skor akhir yang dihasilkan berada dalam rentang 310-677.
 * Perhitungan menggunakan tabel konversi standar yang disesuaikan (scaled)
 * dengan jumlah soal yang ada di dalam paket tes.
 */
class ToeflScoreConverter
{
    // Tabel konversi untuk Listening Comprehension (berdasarkan 50 soal standar)
    private $listeningConversionTable = [
        0 => 31, // Disesuaikan agar skor minimal 310
        1 => 32, // Nilai setelah ini bisa disesuaikan/dicari dari referensi tabel resmi
        2 => 32,
        3 => 33,
        4 => 35,
        5 => 37,
        6 => 37,
        7 => 38,
        8 => 39,
        9 => 41,
        10 => 41,
        11 => 42,
        12 => 43,
        13 => 44,
        14 => 45,
        15 => 45,
        16 => 46,
        17 => 47,
        18 => 47,
        19 => 48,
        20 => 48,
        21 => 49,
        22 => 50,
        23 => 50,
        24 => 51,
        25 => 51,
        26 => 52,
        27 => 52,
        28 => 53,
        29 => 54,
        30 => 54,
        31 => 55,
        32 => 56,
        33 => 57,
        34 => 57,
        35 => 58,
        36 => 59,
        37 => 60,
        38 => 61,
        39 => 62,
        40 => 63,
        41 => 65,
        42 => 66,
        43 => 67,
        44 => 67,
        45 => 68,
        46 => 68,
        47 => 68,
        48 => 68,
        49 => 68,
        50 => 68
    ];

    // Tabel konversi untuk Structure & Written Expression (berdasarkan 40 soal standar)
    private $structureConversionTable = [
        0 => 29, // Disesuaikan agar skor minimal 310
        1 => 30, // Nilai setelah ini bisa disesuaikan/dicari dari referensi tabel resmi
        2 => 31,
        3 => 32,
        4 => 33,
        5 => 35,
        6 => 36,
        7 => 37,
        8 => 38,
        9 => 40,
        10 => 40,
        11 => 41,
        12 => 42,
        13 => 43,
        14 => 44,
        15 => 45,
        16 => 46,
        17 => 47,
        18 => 48,
        19 => 49,
        20 => 50,
        21 => 51,
        22 => 52,
        23 => 53,
        24 => 54,
        25 => 55,
        26 => 56,
        27 => 57,
        28 => 58,
        29 => 60,
        30 => 61,
        31 => 62,
        32 => 63,
        33 => 65,
        34 => 66,
        35 => 67,
        36 => 68,
        37 => 68,
        38 => 68,
        39 => 68,
        40 => 68
    ];

    // Tabel konversi untuk Reading Comprehension (berdasarkan 50 soal standar)
    private $readingConversionTable = [
        0 => 33, // Disesuaikan agar skor minimal 310
        1 => 34, // Nilai setelah ini bisa disesuaikan/dicari dari referensi tabel resmi
        2 => 35,
        3 => 36,
        4 => 37,
        5 => 38,
        6 => 39,
        7 => 40,
        8 => 41,
        9 => 42,
        10 => 43,
        11 => 43,
        12 => 44,
        13 => 45,
        14 => 46,
        15 => 46,
        16 => 47,
        17 => 48,
        18 => 48,
        19 => 49,
        20 => 50,
        21 => 50,
        22 => 51,
        23 => 52,
        24 => 52,
        25 => 53,
        26 => 54,
        27 => 54,
        28 => 55,
        29 => 56,
        30 => 56,
        31 => 57,
        32 => 58,
        33 => 59,
        34 => 60,
        35 => 61,
        36 => 62,
        37 => 63,
        38 => 64,
        39 => 65,
        40 => 66,
        41 => 67,
        42 => 67,
        43 => 67,
        44 => 67,
        45 => 67,
        46 => 67,
        47 => 67,
        48 => 67,
        49 => 67,
        50 => 67
    ];

    /**
     * Method utama untuk menghitung skor.
     */
    public function calculate(array $sectionsData): array
    {
        $convertedScores = [];

        $convertedScores['listening'] = $this->getScaledConvertedScore(
            $sectionsData['listening']['correct'] ?? 0,
            $sectionsData['listening']['total'] ?? 0,
            50,
            $this->listeningConversionTable
        );

        $convertedScores['structure'] = $this->getScaledConvertedScore(
            $sectionsData['structure']['correct'] ?? 0,
            $sectionsData['structure']['total'] ?? 0,
            40,
            $this->structureConversionTable
        );

        $convertedScores['reading'] = $this->getScaledConvertedScore(
            $sectionsData['reading']['correct'] ?? 0,
            $sectionsData['reading']['total'] ?? 0,
            50,
            $this->readingConversionTable
        );

        $totalConvertedScore = array_sum($convertedScores);
        $finalScore = round(($totalConvertedScore * 10) / 3);

        return [
            'score_listening' => $convertedScores['listening'],
            'score_structure' => $convertedScores['structure'],
            'score_reading'   => $convertedScores['reading'],
            'total_score'     => (int) $finalScore,
        ];
    }

    /**
     * Helper untuk mendapatkan skor konversi yang sudah disesuaikan (scaled).
     */
    private function getScaledConvertedScore(int $correctAnswers, int $totalQuestions, int $standardTotalQuestions, array $conversionTable): int
    {
        if ($totalQuestions == 0) {
            // Jika tidak ada soal, maka skor konversinya adalah nilai terendah dari tabel
            return reset($conversionTable);
        }

        $scaledCorrect = round(($correctAnswers / $totalQuestions) * $standardTotalQuestions);

        if (!isset($conversionTable[$scaledCorrect])) {
            return $scaledCorrect > 0 ? end($conversionTable) : reset($conversionTable);
        }

        return $conversionTable[$scaledCorrect];
    }
}