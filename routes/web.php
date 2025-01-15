<?php

use App\Http\Controllers\CoreController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [CoreController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/dashboard', [CoreController::class, 'storeRequestRole'])->middleware('auth')->name('submission.role');

Route::middleware(['auth', 'role:SuperAdmin|Instruktur|Admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
