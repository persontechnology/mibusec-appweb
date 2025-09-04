<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\StopTimeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/stoptimes', [StopTimeController::class, 'index'])->name('stopTimes.index');
Route::get('/getRoutes', [StopTimeController::class, 'getRoutes'])->name('stopTimes.getRoutes');
Route::get('{route}/stopes', [RouteController::class, 'getStopes'])->name('routes.getStopes');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // stops resource routes
    Route::resource('stops', StopController::class);
    Route::resource('routes', RouteController::class);
    Route::resource('vehicles', VehicleController::class);
});

require __DIR__ . '/auth.php';
