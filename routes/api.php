<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\UserCarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class)->only(['store', 'update', 'destroy']);
Route::resource('cars', CarController::class)->only(['index', 'store', 'update', 'destroy']);

Route::prefix('users/{id}/cars')->controller(UserCarController::class)->group(function () {
    route::get('/', 'index');
    route::post('/{carId}/attach', 'attach');
    route::post('/{carId}/detach', 'detach');
});
