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
        0 => 24,
        1 => 25,
        2 => 26,
        3 => 27,
        4 => 28,
        5 => 29,
        6 => 30,
        7 => 31,
        8 => 32,
        9 => 32,
        10 => 33,
        11 => 35,
        12 => 37,
        13 => 37,
        14 => 38,
        15 => 41,
        16 => 41,
        17 => 42,
        18 => 43,
        19 => 44,
        20 => 45,
        21 => 45,
        22 => 46,
        23 => 47,
        24 => 47,
        25 => 48,
        26 => 48,
        27 => 49,
        28 => 50,
        29 => 51,
        30 => 51,
        31 => 52,
        32 => 52,
        33 => 53,
        34 => 54,
        35 => 54,
        36 => 55,
        37 => 56,
        38 => 57,
        39 => 58,
        40 => 59,
        41 => 60,
        42 => 61,
        43 => 62,
        44 => 63,
        45 => 65,
        46 => 66,
        47 => 67,
        48 => 67,
        49 => 68,
        50 => 68
    ];

    // Tabel konversi untuk Structure & Written Expression (berdasarkan 40 soal standar)
    private $structureConversionTable = [
        0 => 20,
        1 => 20,
        2 => 21,
        3 => 22,
        4 => 23,
        5 => 25,
        6 => 26,
        7 => 27,
        8 => 29,
        9 => 31,
        10 => 33,
        11 => 35,
        12 => 36,
        13 => 37,
        14 => 38,
        15 => 40,
        16 => 40,
        17 => 41,
        18 => 42,
        19 => 43,
        20 => 44,
        21 => 45,
        22 => 46,
        23 => 47,
        24 => 48,
        25 => 49,
        26 => 50,
        27 => 51,
        28 => 52,
        29 => 54,
        30 => 55,
        31 => 56,
        32 => 57,
        33 => 58,
        34 => 60,
        35 => 61,
        36 => 63,
        37 => 65,
        38 => 67,
        39 => 68,
        40 => 68
    ];

    // Tabel konversi untuk Reading Comprehension (berdasarkan 50 soal standar)
    private $readingConversionTable = [
        0 => 21,
        1 => 22,
        2 => 23,
        3 => 24,
        4 => 25,
        5 => 26,
        6 => 27,
        7 => 28,
        8 => 29,
        9 => 30,
        10 => 31,
        11 => 32,
        12 => 34,
        13 => 35,
        14 => 36,
        15 => 37,
        16 => 38,
        17 => 39,
        18 => 40,
        19 => 41,
        20 => 42,
        21 => 43,
        22 => 43,
        23 => 44,
        24 => 45,
        25 => 46,
        26 => 47,
        27 => 48,
        28 => 48,
        29 => 49,
        30 => 50,
        31 => 51,
        32 => 52,
        33 => 52,
        34 => 53,
        35 => 54,
        36 => 54,
        37 => 55,
        38 => 56,
        39 => 57,
        40 => 58,
        41 => 59,
        42 => 60,
        43 => 61,
        44 => 62,
        45 => 63,
        46 => 65,
        47 => 66,
        48 => 67,
        49 => 67,
        50 => 67
    ];

    /**
     * Method utama untuk menghitung skor.
     *
     * @param array $sectionsData Data berisi jumlah benar dan total soal per seksi.
     * @return array Mengembalikan array berisi skor konversi per seksi dan skor total ITP.
     */
    public function calculate(array $sectionsData): array
    {
        $convertedScores = [];

        // 1. Hitung skor konversi untuk setiap seksi dengan penyesuaian skala
        $convertedScores['listening'] = $this->getScaledConvertedScore(
            $sectionsData['listening']['correct'] ?? 0,
            $sectionsData['listening']['total'] ?? 0,
            50, // Jumlah soal standar Listening
            $this->listeningConversionTable
        );

        $convertedScores['structure'] = $this->getScaledConvertedScore(
            $sectionsData['structure']['correct'] ?? 0,
            $sectionsData['structure']['total'] ?? 0,
            40, // Jumlah soal standar Structure
            $this->structureConversionTable
        );

        $convertedScores['reading'] = $this->getScaledConvertedScore(
            $sectionsData['reading']['correct'] ?? 0,
            $sectionsData['reading']['total'] ?? 0,
            50, // Jumlah soal standar Reading
            $this->readingConversionTable
        );

        // 2. Jumlahkan semua skor konversi
        $totalConvertedScore = array_sum($convertedScores);

        // 3. Hitung skor akhir menggunakan rumus ITP
        $finalScore = round(($totalConvertedScore * 10) / 3);

        // 4. Siapkan hasil akhir agar kompatibel dengan TestController
        return [
            'score_listening' => $convertedScores['listening'],
            'score_structure' => $convertedScores['structure'],
            'score_reading'   => $convertedScores['reading'],
            'total_score'     => (int) $finalScore,
        ];
    }

    /**
     * Helper untuk mendapatkan skor konversi yang sudah disesuaikan (scaled).
     *
     * @param int $correctAnswers Jumlah jawaban benar dari tes.
     * @param int $totalQuestions Jumlah total soal dalam tes.
     * @param int $standardTotalQuestions Jumlah soal dalam tes ITP standar.
     * @param array $conversionTable Tabel konversi untuk seksi ini.
     * @return int Skor konversi.
     */
    private function getScaledConvertedScore(int $correctAnswers, int $totalQuestions, int $standardTotalQuestions, array $conversionTable): int
    {
        if ($totalQuestions == 0) {
            return 0;
        }

        // Hitung proporsi jawaban benar, lalu skalakan ke jumlah soal standar
        $scaledCorrect = round(($correctAnswers / $totalQuestions) * $standardTotalQuestions);

        // Ambil skor dari tabel konversi berdasarkan hasil skala
        // Jika kunci tidak ada (jarang terjadi), gunakan skor terendah/teratas
        if (!isset($conversionTable[$scaledCorrect])) {
            return $scaledCorrect > 0 ? end($conversionTable) : reset($conversionTable);
        }

        return $conversionTable[$scaledCorrect];
    }
}
