<?php

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

// Route::get('/test-email', function () {
//     Mail::raw('Ini adalah email percobaan dari Laravel', function ($message) {
//         $message->to('alamat-admin@gmail.com')
//             ->subject('Test Email dari Laravel');
//     });

//     return 'Email sudah dikirim!';
// });



Route::get('/', function () {
    $users = User::where('role', '!=', 'admin')
        ->get();

    return view('home', compact('users'));
})->name('home');

foreach (glob(__DIR__ . '/web/*.php') as $routeFile) {
    require $routeFile;
}
