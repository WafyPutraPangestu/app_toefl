<?php

use App\Http\Controllers\Admin\ReadingController;
use App\Http\Controllers\admin\UserController;
use illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\TestPackageController;
use App\Http\Controllers\admin\QuestionController;
use App\Http\Controllers\admin\UserManagementController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\SettingController;

Route::middleware(['admin'])->group(function () {
  Route::controller(UserController::class)->group(function () {
    Route::post('/user/{user}/approve', 'approve')->name('admin.user.approve');
  });
  Route::get('/questions/template', [QuestionController::class, 'downloadTemplate'])->name('questions.downloadTemplate');
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::resource('test-packages', TestPackageController::class);
  Route::resource('questions', QuestionController::class);
  Route::post('/questions/import', [QuestionController::class, 'importStore'])->name('questions.import.store');
  // download template

  Route::resource('users', UserManagementController::class)->names('manajemen-user');
  Route::patch('/admin/manajemen-user/{user}/approve', [UserManagementController::class, 'approve'])
    ->name('manajemen-user.approve');
  Route::patch('/test-session/{testSession}/approve-retake', [UserManagementController::class, 'approveRetake'])
    ->name('manajemen-user.approve_retake');
  Route::resource('reports', ReportController::class);
  Route::resource('settings', SettingController::class)->only(['index', 'edit', 'update']);

  Route::resource('manajemen-reading', ReadingController::class)->names('manajemen-reading');
});
