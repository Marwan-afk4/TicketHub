<?php

use App\Http\Controllers\Api\Auth\Authcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\User\Booking\BookingController;

Route::middleware(['auth:sanctum','IsUser'])->group(function () {
    Route::controller(BookingController::class)->prefix('/booking')
    ->group(function(){
        Route::get('/lists', 'lists');
        Route::get('/', 'filter');
    });
});