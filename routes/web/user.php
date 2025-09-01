<?php



use App\Http\Controllers\User\TestController;
use App\Http\Controllers\User\CertificateController;
use illuminate\Support\Facades\Route;



Route::middleware(['user'])->group(function () {
  Route::get('/dashboard', [TestController::class, 'dashboard'])->name('user.dashboard');
  Route::prefix('test')->name('user.test.')->group(function () {
    Route::post('/start/{testPackage}', [TestController::class, 'start'])->name('start');

    // Menampilkan satu soal spesifik dalam sesi tes
    Route::get('/session/{session}/question/{question}', [TestController::class, 'showQuestion'])->name('show');

    // Menyimpan jawaban user untuk satu soal
    Route::post('/session/{session}/question/{question}', [TestController::class, 'storeAnswer'])->name('answer.store');

    // Mengakhiri sesi tes dan menghitung skor
    Route::post('/session/{session}/finish', [TestController::class, 'finish'])->name('finish');

    // Menampilkan halaman hasil tes
    Route::get('/result/{session}', [TestController::class, 'showResult'])->name('result');

    // Mengajukan permintaan untuk mengulang tes
    Route::post('/retake/{session}', [TestController::class, 'requestRetake'])->name('requestRetake');
  });
  Route::get('/certificate/{testResult}/download', [CertificateController::class, 'download'])->name('certificate.download');
  // Route::post('/test-session/{testSession}/request-retake', [TestController::class, 'requestRetake'])->name('test.request_retake');
});
