<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TestResult;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan Anda sudah install barryvdh/laravel-dompdf
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /**
     * 5. Mengunduh Sertifikat
     * - Mengambil data hasil tes.
     * - Meng-generate PDF dari Blade view.
     * - Mengirimkan PDF ke browser untuk diunduh.
     */
    public function download(TestResult $testResult)
    {
        // Eager load relasi untuk mendapatkan data user dan paket tes
        $testResult->load('testSession.user', 'testSession.testPackage');

        // Pastikan hanya pemilik hasil tes yang bisa mengunduh sertifikat
        abort_if($testResult->testSession->user_id !== Auth::id(), 403);

        // Siapkan data untuk dikirim ke view sertifikat
        $data = [
            'user' => $testResult->testSession->user,
            'testPackage' => $testResult->testSession->testPackage,
            'result' => $testResult,
        ];

        // Buat PDF dari view 'certificate.blade.php'
        $pdf = Pdf::loadView('user.certificate', $data)
            ->setPaper('a4', 'landscape'); // Atur ukuran kertas menjadi A4 landscape

        $fileName = 'sertifikat-toefl-' . Str::slug($data['user']->name) . '.pdf';
        // $fileName = 'sertifikat-toefl-' . str_slug($data['user']->name) . '.pdf';

        // Kirim PDF ke browser
        return $pdf->stream($fileName);
    }
}
