<?php

use App\Http\Controllers\CoreController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [CoreController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/dashboard', [CoreController::class, 'storeRequestRole'])->middleware('auth')->name('submission.role'); // Role Submission Route

Route::middleware(['auth', 'role:SuperAdmin|Instruktur|Admin'])->group(function () {
    Route::resource('events', EventController::class); // Events Management
    Route::resource('sesi', SesiController::class); // Sesi Management

    /** Session Submission Route */
    Route::post('/sessions', [SesiController::class, 'getSessions'])->name('sessions.get');
    /** End Session Submission Route */

    /** Event Submission Route */
    Route::post('/submission-event/{event}', [EventController::class, 'storeSubmission'])->name('submission.event.store');
    /** End Event Submission Route */
});

require __DIR__ . '/auth.php';
