<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register',[AuthController::class,'Register']);
Route::post('/login',[AuthController::class,'login']);
