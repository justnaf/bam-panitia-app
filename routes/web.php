<?php

use App\Http\Controllers\CoreController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventSumController;
use App\Http\Controllers\ModelActiveEventController;
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
    Route::resource('modelActiveEvents', ModelActiveEventController::class); // Model Active Event

    Route::get('/cnsession-status/{sesi}', [SesiController::class, 'changeSessionStatus'])->name('cnsession.status'); // Ganti Status Sesi

    /** Event Summary Route */
    Route::get('/eventSummary', [EventSumController::class, 'eventSummary'])->name('esummary.index');


    /** Presence Route */
    Route::get('/presences', [CoreController::class, 'presencesIndex'])->name('presences.index');
    Route::get('/presences/{event}/{sesi}', [CoreController::class, 'presencesScanner'])->name('presences.scanner');
    Route::get('/presences/{event}/{sesi}/{qr}', [CoreController::class, 'presencesGetuser'])->name('presences.getuser');
    Route::post('/presences/{event}/{sesi}', [CoreController::class, 'presencesStore'])->name('presences.store');
    /** End Presence Route */

    Route::post('/getuser-joined', [CoreController::class, 'fetchUserJoined'])->name('get.user.joined'); // Untuk Manual Joined Event Model

    /** Session Submission Route */
    Route::post('/sessions', [SesiController::class, 'getSessions'])->name('sessions.get');
    /** End Session Submission Route */

    /** Event Submission Route */
    Route::post('/submission-event/{event}', [EventController::class, 'storeSubmission'])->name('submission.event.store');
    /** End Event Submission Route */
});

require __DIR__ . '/auth.php';
