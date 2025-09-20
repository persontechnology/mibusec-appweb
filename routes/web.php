<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolPermisoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // roles y permisos
    Route::resource('rol-permisos', RolPermisoController::class);

    /* agency routes */
    Route::resource('agencies', AgencyController::class);
    Route::post('agencies/{id}/restore', [AgencyController::class, 'restore'])->name('agencies.restore');
    Route::delete('agencies/{id}/forceDelete', [AgencyController::class, 'forceDelete'])->name('agencies.forceDelete');

    
});

require __DIR__ . '/auth.php';
