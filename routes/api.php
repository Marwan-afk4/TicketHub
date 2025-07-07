<?php

use App\Http\Controllers\Api\Admin\AmintyController;
use App\Http\Controllers\Api\Admin\BookingController;
use App\Http\Controllers\Api\Admin\BusController;
use App\Http\Controllers\Api\Admin\BusTypeController;
use App\Http\Controllers\Api\Admin\CarBrandController;
use App\Http\Controllers\Api\Admin\CarCategoryController;
use App\Http\Controllers\Api\Admin\CarController as AdminCarController;
use App\Http\Controllers\Api\Admin\CarModelController;
use App\Http\Controllers\Api\Admin\CommissionController;
use App\Http\Controllers\Api\Admin\ComplaintController;
use App\Http\Controllers\Api\Admin\ComplaintSubjectController;
use App\Http\Controllers\Api\Admin\CurrancyController;
use App\Http\Controllers\Api\Admin\FeesController;
use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\Admin\NationailtyController;
use App\Http\Controllers\Api\Admin\OperatorController;
use App\Http\Controllers\Api\Admin\OperatorPaymentMethodController;
use App\Http\Controllers\Api\Admin\PaymentController;
use App\Http\Controllers\Api\Admin\PaymentMethodController;
use App\Http\Controllers\Api\Admin\PayoutController;
use App\Http\Controllers\Api\Admin\TrainClassController;
use App\Http\Controllers\Api\Admin\TrainController;
use App\Http\Controllers\Api\Admin\TrainRouteController;
use App\Http\Controllers\Api\Admin\TrainTypeController;
use App\Http\Controllers\Api\Admin\TripController;
use App\Http\Controllers\Api\Admin\TripRequestController;
use App\Http\Controllers\Api\Admin\PrivateRequestController;
use App\Http\Controllers\Api\Admin\PointController;
use App\Http\Controllers\Api\Admin\CurrencyPointController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\UserRequestController;

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\AdminRoleController;

use App\Http\Controllers\Api\Admin\WalletController; 
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/sign_up_google',[AuthController::class,'sign_up_google']);
Route::post('/login_google',[AuthController::class,'login_google']);

Route::get('/lists',[AuthController::class,'lists']);
Route::post('/register',[AuthController::class,'Register']);
Route::post('/send_code',[AuthController::class,'send_code']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/login_agent',[AuthController::class,'login_agent']);
Route::post('/login_user',[AuthController::class,'login_user']);
Route::post('/forget_password',[AuthController::class,'forget_password']);
Route::post('/check_code',[AuthController::class,'check_code']);
Route::post('/change_password',[AuthController::class,'change_password']);
Route::get('/logout',[AuthController::class,'logout'])->middleware(['auth:sanctum']);
Route::get('/delete_account',[AuthController::class,'delete_account'])->middleware(['auth:sanctum', 'IsUser']);


Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {

    Route::get('/admin2/users',[UserController::class,'getUsers']);

    Route::get('/admin/users',[UserController::class,'getUsers'])->middleware(['can:admin_user_view']);

    Route::post('/admin/user/add',[UserController::class,'addUser'])->middleware(['can:admin_user_add']);

    Route::delete('/admin/user/delete/{id}',[UserController::class,'deleteUser'])->middleware(['can:admin_user_delete']);

    Route::put('/admin/user/update/{id}',[UserController::class,'UpdateUser'])->middleware(['can:admin_user_edit']);

/////////////////////////////////////// Admin Role ////////////////////////////////////////////

    Route::get('/admin/admin_role',[AdminRoleController::class,'view'])->middleware(['can:admin_admin_role_view']);

    Route::post('/admin/admin_role/add',[AdminRoleController::class,'create'])->middleware(['can:admin_admin_role_add']);

    Route::delete('/admin/admin_role/delete/{id}',[AdminRoleController::class,'delete'])->middleware(['can:admin_admin_role_delete']);

    Route::post('/admin/admin_role/update/{id}',[AdminRoleController::class,'modify'])->middleware(['can:admin_admin_role_edit']);

/////////////////////////////////////// Admin ////////////////////////////////////////////
    Route::get('/admin2/admin',[AdminController::class,'view']);

    Route::get('/admin/admin',[AdminController::class,'view'])->middleware(['can:admin_admin_view']);

    Route::post('/admin/admin/add',[AdminController::class,'create'])->middleware(['can:admin_admin_add']);

    Route::put('/admin/admin/update/{id}',[AdminController::class,'update'])->middleware(['can:admin_admin_edit']);

    Route::delete('/admin/admin/delete/{id}',[AdminController::class,'delete'])->middleware(['can:admin_admin_delete']);

/////////////////////////////////////// Wallet ////////////////////////////////////////////

    Route::get('/admin/wallet_request',[WalletController::class,'view'])->middleware(['can:admin_wallet_request_view']);

    Route::put('/admin/wallet_request/status/{id}',[WalletController::class,'status'])->middleware(['can:admin_wallet_request_status']);

/////////////////////////////////////// User Request ////////////////////////////////////////////

    Route::get('/admin/user_request',[UserRequestController::class,'view'])->middleware(['can:admin_user_request_view']);

    Route::put('/admin/user_request/status/{id}',[UserRequestController::class,'status'])->middleware(['can:admin_user_request_status']);

/////////////////////////////////////// Point ////////////////////////////////////////////

    Route::get('/admin2/point',[PointController::class,'view']);

    Route::get('/admin/point',[PointController::class,'view'])->middleware(['can:admin_redeem_point_view']);

    Route::get('/admin/point/item/{id}',[PointController::class,'item'])->middleware(['can:admin_redeem_point_view']);

    Route::post('/admin/point/add',[PointController::class,'create'])->middleware(['can:admin_redeem_point_add']);

    Route::put('/admin/point/update/{id}',[PointController::class,'modify'])->middleware(['can:admin_redeem_point_edit']);

    Route::delete('/admin/point/delete/{id}',[PointController::class,'delete'])->middleware(['can:admin_redeem_point_delete']);

/////////////////////////////////// Currency Point /////////////////////////////////////////

    Route::get('/admin2/currency_point',[CurrencyPointController::class,'view']);

    Route::get('/admin/currency_point',[CurrencyPointController::class,'view'])->middleware(['can:admin_point_view']);

    Route::get('/admin/currency_point/item/{id}',[CurrencyPointController::class,'item'])->middleware(['can:admin_point_view']);

    Route::post('/admin/currency_point/add',[CurrencyPointController::class,'create'])->middleware(['can:admin_point_add']);

    Route::put('/admin/currency_point/update/{id}',[CurrencyPointController::class,'modify'])->middleware(['can:admin_point_edit']);

    Route::delete('/admin/currency_point/delete/{id}',[CurrencyPointController::class,'delete'])->middleware(['can:admin_point_delete']);

/////////////////////////////////////// Country ////////////////////////////////////////////

    Route::get('/admin2/countries',[LocationController::class,'getCountries']);

    Route::get('/admin/countries',[LocationController::class,'getCountries'])->middleware(['can:admin_countries_view']);

    Route::post('/admin/country/add',[LocationController::class,'addCountry'])->middleware(['can:admin_countries_add']);

    Route::put('/admin/country/update/{id}',[LocationController::class,'updateCountry'])->middleware(['can:admin_countries_edit']);

    Route::delete('/admin/country/delete/{id}',[LocationController::class,'deleteCountry'])->middleware(['can:admin_countries_delete']);

/////////////////////////////////////// City ////////////////////////////////////////////

    Route::get('/admin2/cities',[LocationController::class,'getCities']);

    Route::get('/admin/cities',[LocationController::class,'getCities'])->middleware(['can:admin_cities_view']);

    Route::post('/admin/city/add',[LocationController::class,'AddCity'])->middleware(['can:admin_cities_add']);

    Route::put('/admin/city/update/{id}',[LocationController::class,'updateCity'])->middleware(['can:admin_cities_edit']);

    Route::delete('/admin/city/delete/{id}',[LocationController::class,'deleteCity'])->middleware(['can:admin_cities_delete']);

/////////////////////////////////////// Zone ////////////////////////////////////////////

    Route::get('/admin2/zones',[LocationController::class,'getZones']);

    Route::get('/admin/zones',[LocationController::class,'getZones'])->middleware(['can:admin_zones_view']);

    Route::post('/admin/zone/add',[LocationController::class,'addZone'])->middleware(['can:admin_zones_add']);

    Route::put('/admin/zone/update/{id}',[LocationController::class,'updateZone'])->middleware(['can:admin_zones_edit']);

    Route::delete('/admin/zone/delete/{id}',[LocationController::class,'deleteZone'])->middleware(['can:admin_zones_delete']);

/////////////////////////////////////// Station ////////////////////////////////////////////

    Route::get('/admin2/stations',[LocationController::class,'getStation']);

    Route::get('/admin/stations',[LocationController::class,'getStation'])->middleware(['can:admin_stations_view']);

    Route::post('/admin/station/add',[LocationController::class,'addStation'])->middleware(['can:admin_stations_add']);

    Route::put('/admin/station/update/{id}',[LocationController::class,'updateStation'])->middleware(['can:admin_stations_edit']);

    Route::delete('/admin/station/delete/{id}',[LocationController::class,'deleteStation'])->middleware(['can:admin_stations_delete']);

/////////////////////////////////////// Busses ////////////////////////////////////////////

    Route::get('/admin2/hiaces',[BusController::class,'getHiace']);

    Route::get('/admin/hiaces',[BusController::class,'getHiace'])->middleware(['can:admin_hiaces_view']);
    
    Route::post('/admin/hiaces/add',[BusController::class,'addBus'])->middleware(['can:admin_hiaces_add']);

    Route::put('/admin/hiaces/update/{id}',[BusController::class,'updateBus'])->middleware(['can:admin_hiaces_edit']);
    
    Route::delete('/admin/hiaces/delete/{id}',[BusController::class,'deleteBus'])->middleware(['can:admin_hiaces_delete']);

    Route::get('/admin2/busses',[BusController::class,'getBus']);

    Route::get('/admin/busses',[BusController::class,'getBus'])->middleware(['can:admin_bus_view']);

    Route::post('/admin/bus/add',[BusController::class,'addBus'])->middleware(['can:admin_bus_add']);

    Route::delete('/admin/bus/delete/{id}',[BusController::class,'deleteBus'])->middleware(['can:admin_bus_delete']);

    Route::put('/admin/bus/update/{id}',[BusController::class,'updateBus'])->middleware(['can:admin_bus_edit']);

    Route::get('/admin/agents',[BusController::class,'getAgents']);

//////////////////////////////////////// Bus Type ////////////////////////////////////////////

    Route::get('/admin2/bus_types',[BusTypeController::class,'getBusType']);

    Route::get('/admin/bus_types',[BusTypeController::class,'getBusType'])->middleware(['can:admin_bus_types_view']);

    Route::put('/admin/bus_types/status/{id}',[BusTypeController::class,'busTypeStatus'])->middleware(['can:admin_bus_types_status']);

    Route::post('/admin/bus_type/add',[BusTypeController::class,'addBusType'])->middleware(['can:admin_bus_types_add']);

    Route::delete('/admin/bus_type/delete/{id}',[BusTypeController::class,'deleteBusType'])->middleware(['can:admin_bus_types_delete']);

    Route::put('/admin/bus_type/update/{id}',[BusTypeController::class,'updateBusType'])->middleware(['can:admin_bus_types_edit']);

/////////////////////////////////////// Payment Method ////////////////////////////////////////////

    Route::get('/admin/payment_methods',[PaymentMethodController::class,'getPaymentMethod'])->middleware(['can:admin_payment_methods_view']);

    Route::post('/admin/payment_method/add',[PaymentMethodController::class,'addPaymentMethod'])->middleware(['can:admin_payment_methods_add']);

    Route::delete('/admin/payment_method/delete/{id}',[PaymentMethodController::class,'deletepaymentMethod'])->middleware(['can:admin_payment_methods_delete']);

    Route::put('/admin/payment_method/update/{id}',[PaymentMethodController::class,'updatePaymentMethod'])->middleware(['can:admin_payment_methods_edit']);

/////////////////////////////////////////// Complaints ////////////////////////////////////////////

    Route::get('/admin/complaints',[ComplaintController::class,'getComplaint'])->middleware(['can:admin_complaints_view']);

    Route::post('/admin/complaint/add',[ComplaintController::class,'addComplaint'])->middleware(['can:admin_complaints_add']);

    Route::delete('/admin/complaint/delete/{id}',[ComplaintController::class,'deleteComplaint'])->middleware(['can:admin_complaints_delete']);

    Route::put('/admin/complaint/resolve/{id}',[ComplaintController::class,'resolveComplaint'])->middleware(['can:admin_complaints_status']);

    Route::put('/admin/complaint/reject/{id}',[ComplaintController::class,'rejectComplaint'])->middleware(['can:admin_complaints_status']);

////////////////////////////////////////// Subject Complaints ///////////////////////////////////////////

    Route::get('/admin/complaint_subjects',[ComplaintSubjectController::class,'getSubjects'])->middleware(['can:admin_complaint_subject_view']);

    Route::post('/admin/complaint_subject/add',[ComplaintSubjectController::class,'addSubject'])->middleware(['can:admin_complaint_subject_add']);

    Route::delete('/admin/complaint_subject/delete/{id}',[ComplaintSubjectController::class,'deleteSubject'])->middleware(['can:admin_complaint_subject_delete']);

    Route::put('/admin/complaint_subject/update/{id}',[ComplaintSubjectController::class,'updateSubject'])->middleware(['can:admin_complaint_subject_edit']);

/////////////////////////////////////////////// Currency ////////////////////////////////////////////

    Route::get('/admin2/currencies',[CurrancyController::class,'getCurrincies']);

    Route::get('/admin/currencies',[CurrancyController::class,'getCurrincies'])->middleware(['can:admin_currencies_view']);

    Route::post('/admin/currency/add',[CurrancyController::class,'addCurrancy'])->middleware(['can:admin_currencies_add']);

    Route::put('/admin/currency/update/{id}',[CurrancyController::class,'updateCurrancy'])->middleware(['can:admin_currencies_edit']);

    Route::delete('/admin/currency/delete/{id}',[CurrancyController::class,'deleteCurrancy'])->middleware(['can:admin_currencies_delete']);

//////////////////////////////////////////////////// Nationality ////////////////////////////////////////////

    Route::get('/admin/nationalities',[NationailtyController::class,'getNationalities'])->middleware(['can:admin_nationalities_view']);

    Route::post('/admin/nationality/add',[NationailtyController::class,'addNationality'])->middleware(['can:admin_nationalities_add']);

    Route::put('/admin/nationality/update/{id}',[NationailtyController::class,'updateNationality'])->middleware(['can:admin_nationalities_edit']);

    Route::delete('/admin/nationality/delete/{id}',[NationailtyController::class,'deleteNationality'])->middleware(['can:admin_nationalities_delete']);

////////////////////////////////////////////////// Operators ////////////////////////////////////////////

    Route::get('/admin2/operators',[OperatorController::class,'getOperators']);

    Route::get('/admin/operators',[OperatorController::class,'getOperators'])->middleware(['can:admin_operators_view']);

    Route::post('/admin/operator/add',[OperatorController::class,'addOperator'])->middleware(['can:admin_operators_add']);

    Route::put('/admin/operator/update/{id}',[OperatorController::class,'updateOperator'])->middleware(['can:admin_operators_edit']);

    Route::delete('/admin/operator/delete/{id}',[OperatorController::class,'deleteOperator'])->middleware(['can:admin_operators_delete']);

/////////////////////////////////////////////// Bookings ///////////////////////////////////////////////

    Route::get('/admin/booking/history',[BookingController::class,'History'])->middleware(['can:admin_booking_view']);

    Route::get('/admin/booking/pending',[BookingController::class,'Upcoming'])->middleware(['can:admin_booking_view']);

    Route::get('/admin/booking/canceled',[BookingController::class,'canceled'])->middleware(['can:admin_booking_view']);

    Route::put('/admin/booking/confirm/{id}',[BookingController::class,'confirmBook'])->middleware(['can:admin_booking_status']);

    Route::put('/admin/booking/cancel/{id}',[BookingController::class,'cancelBook'])->middleware(['can:admin_booking_status']);

/////////////////////////////////////////////// Payments ///////////////////////////////////////////

    Route::get('/admin/pending_payments',[PaymentController::class,'pendintPayment'])->middleware(['can:admin_payment_view']);

    Route::get('/admin/confirmed_payments',[PaymentController::class,'confirmedPayment'])->middleware(['can:admin_payment_view']);

    Route::get('/admin/canceled_payments',[PaymentController::class,'canceledPayment'])->middleware(['can:admin_payment_view']);

    Route::put('/admin/payment/confirm/{id}',[PaymentController::class,'confirmPayment'])->middleware(['can:admin_payment_status']);

    Route::put('/admin/payment/cancel/{id}',[PaymentController::class,'cancelPayment'])->middleware(['can:admin_payment_status']);

////////////////////////////////////////////// Aminites ///////////////////////////////////////////

    Route::get('/admin/aminites',[AmintyController::class,'getAminites'])->middleware(['can:admin_aminites_view']);

    Route::post('/admin/aminity/add',[AmintyController::class,'addAminity'])->middleware(['can:admin_aminites_add']);

    Route::put('/admin/aminity/update/{id}',[AmintyController::class,'updateAminity'])->middleware(['can:admin_aminites_edit']);

    Route::delete('/admin/aminity/delete/{id}',[AmintyController::class,'deleteAminity'])->middleware(['can:admin_aminites_delete']);

///////////////////////////////////////////// Trips Request //////////////////////////////////////////////

    Route::get('/admin/trip_request',[TripRequestController::class,'view'])->middleware(['can:admin_trip_request_view']);

    Route::put('/admin/trip_request/status/{id}',[TripRequestController::class,'status'])->middleware(['can:admin_trip_request_status']);

///////////////////////////////////////////// Private Request //////////////////////////////////////////////

    Route::get('/admin/private_request',[PrivateRequestController::class,'view'])->middleware(['can:admin_private_request_view']);

    Route::post('/admin/private_request/determin_agent',[PrivateRequestController::class,'determin_agent'])->middleware(['can:admin_private_request_add']);

    ///////////////////////////////////////////// Trips //////////////////////////////////////////////

    Route::get('/admin/trips',[TripController::class,'getTrips'])->middleware(['can:admin_trips_view']);

    Route::post('/admin/trip/add',[TripController::class,'addTrip'])->middleware(['can:admin_trips_add']);

    Route::put('/admin/trip/update/{id}',[TripController::class,'updateTrip'])->middleware(['can:admin_trips_edit']);

    Route::delete('/admin/trip/delete/{id}',[TripController::class,'deleteTrip'])->middleware(['can:admin_trips_delete']);

/////////////////////////////////////////////// Car Categories ////////////////////////////////////////////

    Route::get('/admin2/car_categories',[CarCategoryController::class,'getCategories']);

    Route::get('/admin/car_categories',[CarCategoryController::class,'getCategories'])->middleware(['can:admin_car_categories_view']);

    Route::post('/admin/car_category/add',[CarCategoryController::class,'addCarCategories'])->middleware(['can:admin_car_categories_add']);

    Route::put('/admin/car_category/update/{id}',[CarCategoryController::class,'updateCarCategories'])->middleware(['can:admin_car_categories_edit']);

    Route::delete('/admin/car_category/delete/{id}',[CarCategoryController::class,'deleteCarCategories'])->middleware(['can:admin_car_categories_delete']);

///////////////////////////////////////////// Car Brands /////////////////////////////////////////////////////

    Route::get('/admin2/car_brands',[CarBrandController::class,'getBrands']);

    Route::get('/admin/car_brands',[CarBrandController::class,'getBrands'])->middleware(['can:admin_car_brands_view']);

    Route::post('/admin/car_brand/add',[CarBrandController::class,'addBrands'])->middleware(['can:admin_car_brands_add']);

    Route::put('/admin/car_brand/update/{id}',[CarBrandController::class,'updateBrands'])->middleware(['can:admin_car_brands_edit']);

    Route::delete('/admin/car_brand/delete/{id}',[CarBrandController::class,'deleteBrands'])->middleware(['can:admin_car_brands_delete']);

//////////////////////////////////////////// Car Models /////////////////////////////////////////////////////

    Route::get('/admin2/car_models',[CarModelController::class,'getModels']);

    Route::get('/admin/car_models',[CarModelController::class,'getModels'])->middleware(['can:admin_car_models_view']);

    Route::post('/admin/car_model/add',[CarModelController::class,'addCarModel'])->middleware(['can:admin_car_models_add']);

    Route::put('/admin/car_model/update/{id}',[CarModelController::class,'updateCarModel'])->middleware(['can:admin_car_models_edit']);

    Route::delete('/admin/car_model/delete/{id}',[CarModelController::class,'deleteCarModel'])->middleware(['can:admin_car_models_delete']);

///////////////////////////////////////////// Cars ///////////////////////////////////////////

    Route::get('/admin/cars',[AdminCarController::class,'getCar'])->middleware(['can:admin_cars_view']);

    Route::post('/admin/car/add',[AdminCarController::class,'addCar'])->middleware(['can:admin_cars_add']);

    Route::put('/admin/car/update/{id}',[AdminCarController::class,'updateCar'])->middleware(['can:admin_cars_edit']);

    Route::delete('/admin/car/delete/{id}',[AdminCarController::class,'deleteCar'])->middleware(['can:admin_cars_delete']);

    Route::get('/admin/agent_cars/{agent_id}',[AdminCarController::class,'getAgentCars'])->middleware(['can:admin_cars_view']);

/////////////////////////////////////////// Train Type //////////////////////////////////////////////

    Route::get('/admin2/trainTypes',[TrainTypeController::class,'getTypes']);

    Route::get('/admin/trainTypes',[TrainTypeController::class,'getTypes'])->middleware(['can:admin_trainTypes_view']);

    Route::post('/admin/trainType/add',[TrainTypeController::class,'addType'])->middleware(['can:admin_trainTypes_add']);

    Route::put('/admin/trainType/update/{id}',[TrainTypeController::class,'updateType'])->middleware(['can:admin_trainTypes_edit']);

    Route::delete('/admin/trainType/delete/{id}',[TrainTypeController::class,'deleteType'])->middleware(['can:admin_trainTypes_delete']);

////////////////////////////////////////// Train Class //////////////////////////////////////////////

    Route::get('/admin/trainclasses',[TrainClassController::class,'getClasses']);

    Route::get('/admin/trainclasses',[TrainClassController::class,'getClasses'])->middleware(['can:admin_trainclasses_view']);

    Route::post('/admin/trainclass/add',[TrainClassController::class,'addClass'])->middleware(['can:admin_trainclasses_add']);

    Route::put('/admin/trainclass/update/{id}',[TrainClassController::class,'updateClass'])->middleware(['can:admin_trainclasses_edit']);

    Route::delete('/admin/trainclass/delete/{id}',[TrainClassController::class,'deleteClass'])->middleware(['can:admin_trainclasses_delete']);

////////////////////////////////////////// Train Route //////////////////////////////////////////////

    Route::get('/admin2/trainRoutes',[TrainRouteController::class,'getRoutes']);

    Route::get('/admin/trainRoutes',[TrainRouteController::class,'getRoutes'])->middleware(['can:admin_trainRoutes_view']);

    Route::post('/admin/trainRoute/add',[TrainRouteController::class,'addRoute'])->middleware(['can:admin_trainRoutes_add']);

    Route::put('/admin/trainRoute/update/{id}',[TrainRouteController::class,'updateRoute'])->middleware(['can:admin_trainRoutes_edit']);

    Route::delete('/admin/trainRoute/delete/{id}',[TrainRouteController::class,'deleteRoute'])->middleware(['can:admin_trainRoutes_delete']);

////////////////////////////////////////////// Train //////////////////////////////////////////////

    Route::get('/admin2/trains',[TrainController::class,'getTrains']);

    Route::get('/admin/trains',[TrainController::class,'getTrains'])->middleware(['can:admin_trains_view']);

    Route::post('/admin/train/add',[TrainController::class,'addTrain'])->middleware(['can:admin_trains_add']);

    Route::put('/admin/train/update/{id}',[TrainController::class,'modifyTrain'])->middleware(['can:admin_trains_edit']);

    Route::delete('/admin/train/delete/{id}',[TrainController::class,'deleteTrain'])->middleware(['can:admin_trains_delete']);

//////////////////////////////////////// Commission //////////////////////////////////////////////

    Route::get('/admin/AllCommissions',[CommissionController::class,'getAllCommission'])->middleware(['can:admin_Commission_view']);

    Route::get('/admin/CommissionAgent/{id}',[CommissionController::class,'getAgentCommission'])->middleware(['can:admin_Commission_view']);

    Route::post('/admin/CommissionDefault/add',[CommissionController::class,'addDefultCommission'])->middleware(['can:admin_Commission_add']);

    Route::post('/admin/CommissionAgent/add',[CommissionController::class,'addAgentCommission'])->middleware(['can:admin_Commission_add']);

    Route::get('/admin/defaultCommission',[CommissionController::class,'getDefaultCommission'])->middleware(['can:admin_Commission_view']);

    Route::put('/admin/defaultCommission/update/{id}',[CommissionController::class,'updateDefaultCommission'])->middleware(['can:admin_Commission_edit']);

/////////////////////////////////////////////// operator Payment Method ////////////////////////////////////////////

    Route::get('/admin/operator_payment_methods',[OperatorPaymentMethodController::class,'getOperatorPaymentMetod'])->middleware(['can:admin_operator_payment_methods_view']);

    Route::post('/admin/operator_payment_method/add',[OperatorPaymentMethodController::class,'addOperatorPaymentMethod'])->middleware(['can:admin_operator_payment_methods_add']);

    Route::put('/admin/operator_payment_method/update/{id}',[OperatorPaymentMethodController::class,'updateOperatorPaymentMethod'])->middleware(['can:admin_operator_payment_methods_edit']);

    Route::delete('/admin/operator_payment_method/delete/{id}',[OperatorPaymentMethodController::class,'deleteOperatorPaymentMethod'])->middleware(['can:admin_operator_payment_methods_delete']);

//////////////////////////////////////////////////// Payout Request ////////////////////////////////////////////

    Route::put('/admin/payoutRequest/cancel/{id}',[PayoutController::class,'cancelPayout'])->middleware(['can:admin_payoutRequest_status']);

    Route::get('/admin/payoutRequest',[PayoutController::class,'getPayoutRequest'])->middleware(['can:admin_payoutRequest_view']);

    Route::put('/admin/payoutRequest/confirm/{id}',[PayoutController::class,'confirmPayout'])->middleware(['can:admin_payoutRequest_status']);

    Route::get('/admin/payoutRequest/history',[PayoutController::class,'getHistoryPayout'])->middleware(['can:admin_payoutRequest_view']);

    Route::get('/admin/canceledPayoutRequest',[PayoutController::class,'canceledPayoutRequest'])->middleware(['can:admin_payoutRequest_view']);

////////////////////////////////////////////////// Fees ///////////////////////////////////////////////////////////

    Route::get('/admin/fees',[FeesController::class,'getFees'])->middleware(['can:admin_fees_view']);

    Route::post('/admin/fees/add',[FeesController::class,'addFees'])->middleware(['can:admin_fees_add']);

    Route::put('/admin/fees/update/{id}',[FeesController::class,'updateFees'])->middleware(['can:admin_fees_edit']);

    Route::delete('/admin/fees/delete/{id}',[FeesController::class,'deleteFees'])->middleware(['can:admin_fees_delete']);
});
