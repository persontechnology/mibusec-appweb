<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolPermisoController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\VehicleController;
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

    //
    Route::prefix('routes')->group(function () {
        Route::get('create', [RouteController::class, 'create'])->name('create');
        Route::get('{route}/create', [RouteController::class, 'createStops'])->name('routes.stops.create');
        Route::get('{route}/stops', [RouteController::class, 'stops'])->name('routes.stops.index');
        Route::post('store-stops', [RouteController::class, 'storeStop'])->name('routes.stops.store');
        Route::post('{route}/stops/{stop}/attach', [RouteController::class, 'attach'])->name('routes.stops.attach');
    });
    // roles y permisos
    Route::resource('rol-permisos', RolPermisoController::class);

    /* agency routes */
    Route::resource('agencies', AgencyController::class);
    Route::post('agencies/{id}/restore', [AgencyController::class, 'restore'])->name('agencies.restore');
    Route::delete('agencies/{id}/forceDelete', [AgencyController::class, 'forceDelete'])->name('agencies.forceDelete');

    /* vehicle routes */
    Route::resource('vehicles', VehicleController::class);



    // routes resource routes
    Route::resource('routes', RouteController::class);
    Route::resource('stops', StopController::class);
    // stops resource routes


});

require __DIR__ . '/auth.php';
