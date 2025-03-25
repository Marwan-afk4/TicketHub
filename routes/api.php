<?php

use App\Http\Controllers\Api\Admin\BusController;
use App\Http\Controllers\Api\Admin\BusTypeController;
use App\Http\Controllers\Api\Admin\ComplaintController;
use App\Http\Controllers\Api\Admin\ComplaintSubjectController;
use App\Http\Controllers\Api\Admin\CurrancyController;
use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\Admin\NationailtyController;
use App\Http\Controllers\Api\Admin\PaymentMethodController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/lists',[AuthController::class,'lists']);
Route::post('/register',[AuthController::class,'Register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/forget_password',[AuthController::class,'forget_password']);
Route::post('/check_code',[AuthController::class,'check_code']);
Route::post('/change_password',[AuthController::class,'change_password']);


Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {

    Route::get('/admin/users',[UserController::class,'getUsers']);

    Route::post('/admin/user/add',[UserController::class,'addUser']);

    Route::delete('/admin/user/delete/{id}',[UserController::class,'deleteUser']);

    Route::put('/admin/user/update/{id}',[UserController::class,'UpdateUser']);

/////////////////////////////////////// Country ////////////////////////////////////////////

    Route::get('/admin/countries',[LocationController::class,'getCountries']);

    Route::post('/admin/country/add',[LocationController::class,'addCountry']);

    Route::put('/admin/country/update/{id}',[LocationController::class,'updateCountry']);

    Route::delete('/admin/country/delete/{id}',[LocationController::class,'deleteCountry']);

/////////////////////////////////////// City ////////////////////////////////////////////

    Route::get('/admin/cities',[LocationController::class,'getCities']);

    Route::post('/admin/city/add',[LocationController::class,'AddCity']);

    Route::put('/admin/city/update/{id}',[LocationController::class,'updateCity']);

    Route::delete('/admin/city/delete/{id}',[LocationController::class,'deleteCity']);

/////////////////////////////////////// Zone ////////////////////////////////////////////

    Route::get('/admin/zones',[LocationController::class,'getZones']);

    Route::post('/admin/zone/add',[LocationController::class,'addZone']);

    Route::put('/admin/zone/update/{id}',[LocationController::class,'updateZone']);

    Route::delete('/admin/zone/delete/{id}',[LocationController::class,'deleteZone']);

/////////////////////////////////////// Station ////////////////////////////////////////////

    Route::get('/admin/stations',[LocationController::class,'getStation']);

    Route::post('/admin/station/add',[LocationController::class,'addStation']);

    Route::put('/admin/station/update/{id}',[LocationController::class,'updateStation']);

    Route::delete('/admin/station/delete/{id}',[LocationController::class,'deleteStation']);

/////////////////////////////////////// Busses ////////////////////////////////////////////

    Route::get('/admin/busses',[BusController::class,'getBus']);

    Route::post('/admin/bus/add',[BusController::class,'addBus']);

    Route::get('/admin/agents',[BusController::class,'getAgents']);

    Route::delete('/admin/bus/delete/{id}',[BusController::class,'deleteBus']);

    Route::put('/admin/bus/update/{id}',[BusController::class,'updateBus']);

//////////////////////////////////////// Bus Type ////////////////////////////////////////////

    Route::get('/admin/bus_types',[BusTypeController::class,'getBusType']);

    Route::put('/admin/bus_types/status/{id}',[BusTypeController::class,'busTypeStatus']);

    Route::post('/admin/bus_type/add',[BusTypeController::class,'addBusType']);

    Route::delete('/admin/bus_type/delete/{id}',[BusTypeController::class,'deleteBusType']);

    Route::put('/admin/bus_type/update/{id}',[BusTypeController::class,'updateBusType']);

/////////////////////////////////////// Payment Method ////////////////////////////////////////////

    Route::get('/admin/payment_methods',[PaymentMethodController::class,'getPaymentMethod']);

    Route::post('/admin/payment_method/add',[PaymentMethodController::class,'addPaymentMethod']);

    Route::delete('/admin/payment_method/delete/{id}',[PaymentMethodController::class,'deletepaymentMethod']);

    Route::put('/admin/payment_method/update/{id}',[PaymentMethodController::class,'updatePaymentMethod']);

/////////////////////////////////////////// Complaints ////////////////////////////////////////////

    Route::get('/admin/complaints',[ComplaintController::class,'getComplaint']);

    Route::post('/admin/complaint/add',[ComplaintController::class,'addComplaint']);

    Route::delete('/admin/complaint/delete/{id}',[ComplaintController::class,'deleteComplaint']);

    Route::put('/admin/complaint/resolve/{id}',[ComplaintController::class,'resolveComplaint']);

    Route::put('/admin/complaint/reject/{id}',[ComplaintController::class,'rejectComplaint']);

////////////////////////////////////////// Subject Complaints ///////////////////////////////////////////

    Route::get('/admin/complaint_subjects',[ComplaintSubjectController::class,'getSubjects']);

    Route::post('/admin/complaint_subject/add',[ComplaintSubjectController::class,'addSubject']);

    Route::delete('/admin/complaint_subject/delete/{id}',[ComplaintSubjectController::class,'deleteSubject']);

    Route::put('/admin/complaint_subject/update/{id}',[ComplaintSubjectController::class,'updateSubject']);

/////////////////////////////////////////////// Currency ////////////////////////////////////////////

    Route::get('/admin/currencies',[CurrancyController::class,'getCurrincies']);

    Route::post('/admin/currency/add',[CurrancyController::class,'addCurrancy']);

    Route::put('/admin/currency/update/{id}',[CurrancyController::class,'updateCurrancy']);

    Route::delete('/admin/currency/delete/{id}',[CurrancyController::class,'deleteCurrancy']);

//////////////////////////////////////////////////// Nationality ////////////////////////////////////////////

    Route::get('/admin/nationalities',[NationailtyController::class,'getNationalities']);

    Route::post('/admin/nationality/add',[NationailtyController::class,'addNationality']);

    Route::put('/admin/nationality/update/{id}',[NationailtyController::class,'updateNationality']);

    Route::delete('/admin/nationality/delete/{id}',[NationailtyController::class,'deleteNationality']);
});
