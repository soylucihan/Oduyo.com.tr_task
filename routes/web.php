<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueManagementController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/reset-password', [RegisterController::class, 'resetPassword'])->name('reset');
Route::get('/reset-password', [RegisterController::class, 'reset'])->name('reset');

Route::get('/queue-management', [QueueManagementController::class, 'index']);
Route::post('/queue-management/cancel/{jobId}', [QueueManagementController::class, 'cancelJob'])->name('cancelJob');
Route::post('/queue-management/re-execute/{jobId}', [QueueManagementController::class, 'reExecuteJob'])->name('reExecuteJob');