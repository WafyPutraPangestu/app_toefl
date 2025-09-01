<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SessionController;
use \Illuminate\Support\Facades\Route;



Route::middleware(['guest'])->group(function () {
  Route::controller(SessionController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'authenticate')->name('login.store');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store')->name('register.store');
  });

  Route::controller(GoogleController::class)->group(function () {
    Route::get('/login/google', 'redirectToGoogle')->name('login.google');
    Route::get('/signup/google', function () {
      return app(GoogleController::class)->redirectToGoogle('signup');
    })->name('signup.google');
    Route::get('/redirect', 'handleGoogleCallback')->name('login.google.callback');
    // Route::get('/auth/google/{mode}', 'redirectToGoogle')
    //   ->where('mode', 'login|signup')
    //   ->name('auth.google.mode');
  });
});

Route::middleware(['auth'])->group(function () {
  Route::controller(SessionController::class)->group(function () {
    Route::post('/logout', 'logout')->name('logout');
  });
});
