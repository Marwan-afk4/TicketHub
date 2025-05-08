<?php

use App\Http\Controllers\Api\Auth\Authcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Agent\Car\CarController;
use App\Http\Controllers\Api\Agent\Bus\BusController;
use App\Http\Controllers\Api\Agent\Hiace\HiaceController;
use App\Http\Controllers\Api\Agent\Train\TrainController;
use App\Http\Controllers\Api\Agent\Profile\ProfileController;
use App\Http\Controllers\Api\Agent\Trip\TripController;
use App\Http\Controllers\Api\Agent\Booking\BookingController;
use App\Http\Controllers\Api\Agent\Payout\PayoutController;
use App\Http\Controllers\Api\Agent\Wallet\WalletController;
use App\Http\Controllers\Api\Agent\Private\PrivateRequestController;
use App\Http\Controllers\Api\Agent\Reports\BookingReportController;
use App\Http\Controllers\Api\Agent\Reports\EarningReportController;
use App\Http\Controllers\Api\Agent\Payment\PaymentController;

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

    Route::controller(TrainController::class)
    ->middleware(['can:isTrain'])->prefix('train')->group(function(){
        Route::get('/', 'view');
        Route::get('/item/{id}', 'train');
        Route::put('/status/{id}', 'status');
        Route::post('/add', 'create');
        Route::post('/update/{id}', 'modify');
        Route::delete('/delete/{id}', 'delete');
    });

    Route::controller(PrivateRequestController::class)
    ->prefix('private_request')->group(function(){
        Route::get('/', 'view');
        Route::put('/cancel/{id}', 'cancel');
    });

    Route::controller(HiaceController::class)
    ->middleware(['can:isHiace'])->prefix('hiace')->group(function(){
        Route::get('/', 'view');
        Route::get('/item/{id}', 'hiace');
        Route::post('/add', 'create');
        Route::post('/update/{id}', 'modify');
        Route::delete('/delete/{id}', 'delete');
    });

    Route::controller(ProfileController::class)
    ->prefix('profile')->group(function(){
        Route::get('/', 'view');
        Route::post('/update', 'update');
    });

    Route::controller(TripController::class)
    ->prefix('trip')->group(function(){
        Route::get('/', 'view');
        Route::get('/item/{id}', 'trip');
        Route::post('/add', 'create');
        Route::post('/update/{id}', 'modify');
        Route::delete('/delete/{id}', 'delete');
    });

    Route::controller(BookingController::class)
    ->prefix('bookings')->group(function(){
        Route::get('/', 'view');
        Route::put('/status/{id}', 'status');
    });

    Route::controller(PaymentController::class)
    ->prefix('payments')->group(function(){
        Route::get('/', 'view');
    });

    Route::controller(PayoutController::class)
    ->prefix('payout')->group(function(){
        Route::get('/', 'history');
        Route::post('/request', 'payout_request');
    });

    Route::controller(WalletController::class)
    ->prefix('wallet')->group(function(){
        Route::get('/', 'view');
    });

    Route::controller(BookingReportController::class)
    ->prefix('report/booking')->group(function(){
        Route::get('/', 'view');
    });

    Route::controller(EarningReportController::class)
    ->prefix('report/earning')->group(function(){
        Route::get('/', 'view');
    });
});