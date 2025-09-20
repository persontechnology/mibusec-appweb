<?php

use App\Http\Controllers\Api\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* biene por defecto al instalar api routes */
/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

Route::get('/getdevices',[VehicleController::class,'getDeviceEcuatrackApi'])->name('api.getdevices');
