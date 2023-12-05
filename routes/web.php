<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueManagementController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Route for displaying Register form.
 */
Route::get('/register', [RegisterController::class, 'index'])->name('register');

/**
 * Route for handling user registration.
 */
Route::post('/register', [RegisterController::class, 'register'])->name('register');

/**
 * Route for resetting user password.
 */
Route::post('/reset-password', [RegisterController::class, 'resetPassword'])->name('reset');

/**
 * Route for displaying password reset form.
 */
Route::get('/reset-password', [RegisterController::class, 'reset'])->name('reset');

/**
 * Route for managing the queue.
 */
Route::get('/queue-management', [QueueManagementController::class, 'index']);

/**
 * Route for canceling a job in the queue.
 */
Route::post('/queue-management/cancel/{jobId}', [QueueManagementController::class, 'cancelJob'])->name('cancelJob');

/**
 * Route for re-executing a job in the queue.
 */
Route::post('/queue-management/re-execute/{jobId}', [QueueManagementController::class, 'reExecuteJob'])->name('reExecuteJob');