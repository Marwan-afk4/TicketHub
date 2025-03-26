<?php

use App\Http\Controllers\Api\Auth\Authcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Agent\Car\CarController;
use App\Http\Controllers\Api\Agent\Bus\BusController;

Route::middleware(['auth:sanctum','IsAgent'])->group(function () {
    Route::controller(CarController::class)
    ->middleware(['can:isPrivate'])->prefix('car')->group(function(){
        Route::get('/', 'view');
        Route::get('/item/{id}', 'car');
        Route::post('/add', 'create');
        Route::post('/update/{id}', 'modify');
        Route::delete('/delete/{id}', 'delete');
    });

    Route::controller(BusController::class)
    ->middleware(['can:isBus'])->prefix('bus')->group(function(){
        Route::get('/', 'view');
        Route::get('/item/{id}', 'bus');
        Route::post('/add', 'create');
        Route::post('/update/{id}', 'modify');
        Route::delete('/delete/{id}', 'delete');
    });
});