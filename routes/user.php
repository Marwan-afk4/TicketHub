<?php

use App\Http\Controllers\Api\Auth\Authcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\User\Booking\BookingController;
use App\Http\Controllers\Api\User\Profile\ProfileController;
use App\Http\Controllers\Api\User\Wallet\WalletController;

Route::middleware(['auth:sanctum','IsUser'])->group(function () {
    Route::controller(BookingController::class)->prefix('/booking')
    ->group(function(){
        Route::get('/lists', 'lists');
        Route::get('/history', 'history');
        Route::post('/', 'filter');
        Route::post('/payment', 'payment');
        Route::post('/payment_wallet', 'payment_wallet');
        Route::post('/private_request', 'private_request');
    });

    Route::controller(ProfileController::class)->prefix('/profile')
    ->group(function(){
        Route::get('/', 'view');
        Route::post('/update', 'update');
    });

    Route::controller(WalletController::class)->prefix('/wallet')
    ->group(function(){
        Route::get('/', 'view');
        Route::post('/charge', 'charge');
    });
});