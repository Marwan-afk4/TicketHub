<?php

use App\Http\Controllers\Api\Auth\Authcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\User\Booking\BookingController;
use App\Http\Controllers\Api\User\Profile\ProfileController;
use App\Http\Controllers\Api\User\Wallet\WalletController;
use App\Http\Controllers\Api\User\Points\PointsController;

Route::middleware(['auth:sanctum','IsUser'])->group(function () {
    Route::controller(BookingController::class)->prefix('/booking')
    ->group(function(){
        Route::get('/lists', 'lists')->withOutMiddleware(['auth:sanctum', 'IsUser']);
        Route::get('/history', 'history');
        Route::post('/', 'filter')->withOutMiddleware(['auth:sanctum', 'IsUser']);
        Route::post('/payment', 'payment');
        Route::post('/payment_wallet', 'payment_wallet');
        Route::post('/private_request', 'private_request');
        Route::post('/private_request_history', 'private_request_history');
        Route::post('/cancel/{id}', 'cancel');
        Route::get('/callback', 'callback')->withoutMiddleware(['auth:sanctum','IsUser']);
    });

    Route::controller(ProfileController::class)->prefix('/profile')
    ->group(function(){
        Route::get('/', 'view');
        Route::post('/update', 'update');
    });

    Route::controller(WalletController::class)->prefix('/wallet')
    ->group(function(){
        Route::get('/', 'view');
        Route::get('/lists', 'lists');
        Route::get('/history', 'history');
        Route::post('/charge', 'charge');
    });

    Route::controller(PointsController::class)->prefix('/points')
    ->group(function(){
        Route::get('/', 'view'); 
        Route::post('/convert', 'convert');
    });
});