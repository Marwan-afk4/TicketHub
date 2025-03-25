<?php

use App\Http\Controllers\Api\Auth\Authcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Agent\Car\CarController;

Route::middleware(['auth:sanctum','IsAgent'])->group(function () {
    Route::controller(CarController::class)
    ->middleware(['can:isPrivate'])->prefix('car')->group(function(){
        Route::get('/', 'view');
        Route::get('/item/{id}', 'car');
        Route::post('/add', 'create');
        Route::post('/update/{id}', 'modify');
        Route::delete('/delete/{id}', 'delete');
    });
});