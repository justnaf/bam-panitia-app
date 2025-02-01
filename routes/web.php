<?php

use App\Http\Controllers\CoreController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventSumController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ModelActiveEventController;
use App\Http\Controllers\PresenceHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/newmenu', function () {
    return view('newmenu');
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

    /** Grade Route */
    Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
    Route::post('/grades/getpeserta', [GradeController::class, 'fetchPeserta'])->name('grades.getpeserta');
    Route::get('/grades/{eventId}', [GradeController::class, 'generateDefault'])->name('grades.generate');
    Route::delete('/grades/{userId}', [GradeController::class, 'gradeDelete'])->name('grades.delete');
    Route::get('/grades/{userId}/{eventId}/edit', [GradeController::class, 'getSesi'])->name('grades.getsesi');
    Route::put('/grades/{userId}/{eventId}/{gradeId}', [GradeController::class, 'update'])->name('grades.update');
    Route::get('/grades/{userId}/{eventId}/{sesiId}/edit', [GradeController::class, 'gradeEdit'])->name('grades.edit');

    /** End Grade Route */

    /** Presence Route */
    Route::post('/get-presences-history', [PresenceHistoryController::class, 'getPresencesHistory'])->name('presences.gethistory');
    Route::post('/presences/update-presence-status', [PresenceHistoryController::class, 'updateStatus'])->name('presences.updateStatus');
    Route::get('/presences/list', [PresenceHistoryController::class, 'listView'])->name('presences.listview');
    Route::get('/presences', [PresenceHistoryController::class, 'presencesIndex'])->name('presences.index');
    Route::get('/presences/{event}/{sesi}', [PresenceHistoryController::class, 'presencesScanner'])->name('presences.scanner');
    Route::get('/presences/{event}/{sesi}/{qr}', [PresenceHistoryController::class, 'presencesGetuser'])->name('presences.getuser');
    Route::post('/presences/{event}/{sesi}', [PresenceHistoryController::class, 'presencesStore'])->name('presences.store');
    /** End Presence Route */

    Route::post('/getuser-joined', [ModelActiveEventController::class, 'fetchUserJoined'])->name('get.user.joined'); // Untuk Manual Joined Event Model

    /** Session Submission Route */
    Route::post('/sessions', [SesiController::class, 'getSessions'])->name('sessions.get');
    /** End Session Submission Route */

    /** Event Submission Route */
    Route::post('/submission-event/{event}', [EventController::class, 'storeSubmission'])->name('submission.event.store');
    /** End Event Submission Route */
});

require __DIR__ . '/auth.php';
