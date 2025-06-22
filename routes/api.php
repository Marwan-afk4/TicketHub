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

    Route::get('/admin/users',[UserController::class,'getUsers']);

    Route::post('/admin/user/add',[UserController::class,'addUser']);

    Route::delete('/admin/user/delete/{id}',[UserController::class,'deleteUser']);

    Route::put('/admin/user/update/{id}',[UserController::class,'UpdateUser']);

/////////////////////////////////////// Admin Role ////////////////////////////////////////////

    Route::get('/admin/admin_role',[AdminRoleController::class,'view']);

    Route::post('/admin/admin_role/add',[AdminRoleController::class,'create']);

    Route::delete('/admin/admin_role/delete/{id}',[AdminRoleController::class,'delete']);

    Route::put('/admin/admin_role/update/{id}',[AdminRoleController::class,'update']);

/////////////////////////////////////// Admin ////////////////////////////////////////////
    Route::get('/admin/admin',[AdminController::class,'view']);

    Route::post('/admin/admin/add',[AdminController::class,'create']);

    Route::delete('/admin/admin/delete/{id}',[AdminController::class,'delete']);

    Route::put('/admin/admin/update/{id}',[AdminController::class,'update']);

/////////////////////////////////////// Wallet ////////////////////////////////////////////

    Route::get('/admin/wallet_request',[WalletController::class,'view']);

    Route::put('/admin/wallet_request/status/{id}',[WalletController::class,'status']);

/////////////////////////////////////// User Request ////////////////////////////////////////////

    Route::get('/admin/user_request',[UserRequestController::class,'view']);

    Route::put('/admin/user_request/status/{id}',[UserRequestController::class,'status']);

/////////////////////////////////////// Point ////////////////////////////////////////////

    Route::get('/admin/point',[PointController::class,'view']);

    Route::get('/admin/point/item/{id}',[PointController::class,'item']);

    Route::post('/admin/point/add',[PointController::class,'create']);

    Route::put('/admin/point/update/{id}',[PointController::class,'modify']);

    Route::delete('/admin/point/delete/{id}',[PointController::class,'delete']);

/////////////////////////////////// Currency Point /////////////////////////////////////////

    Route::get('/admin/currency_point',[CurrencyPointController::class,'view']);

    Route::get('/admin/currency_point/item/{id}',[CurrencyPointController::class,'item']);

    Route::post('/admin/currency_point/add',[CurrencyPointController::class,'create']);

    Route::put('/admin/currency_point/update/{id}',[CurrencyPointController::class,'modify']);

    Route::delete('/admin/currency_point/delete/{id}',[CurrencyPointController::class,'delete']);

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

    Route::get('/admin/hiaces',[BusController::class,'getHiace']);

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

////////////////////////////////////////////////// Operators ////////////////////////////////////////////

    Route::get('/admin/operators',[OperatorController::class,'getOperators']);

    Route::post('/admin/operator/add',[OperatorController::class,'addOperator']);

    Route::put('/admin/operator/update/{id}',[OperatorController::class,'updateOperator']);

    Route::delete('/admin/operator/delete/{id}',[OperatorController::class,'deleteOperator']);

/////////////////////////////////////////////// Bookings ///////////////////////////////////////////////

    Route::get('/admin/booking/history',[BookingController::class,'History']);

    Route::get('/admin/booking/pending',[BookingController::class,'Upcoming']);

    Route::get('/admin/booking/canceled',[BookingController::class,'canceled']);

    Route::put('/admin/booking/confirm/{id}',[BookingController::class,'confirmBook']);

    Route::put('/admin/booking/cancel/{id}',[BookingController::class,'cancelBook']);

/////////////////////////////////////////////// Payments ///////////////////////////////////////////

    Route::get('/admin/pending_payments',[PaymentController::class,'pendintPayment']);

    Route::get('/admin/confirmed_payments',[PaymentController::class,'confirmedPayment']);

    Route::get('/admin/canceled_payments',[PaymentController::class,'canceledPayment']);

    Route::put('/admin/payment/confirm/{id}',[PaymentController::class,'confirmPayment']);

    Route::put('/admin/payment/cancel/{id}',[PaymentController::class,'cancelPayment']);

////////////////////////////////////////////// Aminites ///////////////////////////////////////////

    Route::get('/admin/aminites',[AmintyController::class,'getAminites']);

    Route::post('/admin/aminity/add',[AmintyController::class,'addAminity']);

    Route::put('/admin/aminity/update/{id}',[AmintyController::class,'updateAminity']);

    Route::delete('/admin/aminity/delete/{id}',[AmintyController::class,'deleteAminity']);

///////////////////////////////////////////// Trips Request //////////////////////////////////////////////

    Route::get('/admin/trip_request',[TripRequestController::class,'view']);

    Route::put('/admin/trip_request/status/{id}',[TripRequestController::class,'status']);

///////////////////////////////////////////// Private Request //////////////////////////////////////////////

    Route::get('/admin/private_request',[PrivateRequestController::class,'view']);

    Route::post('/admin/private_request/determin_agent',[PrivateRequestController::class,'determin_agent']);

    ///////////////////////////////////////////// Trips //////////////////////////////////////////////

    Route::get('/admin/trips',[TripController::class,'getTrips']);

    Route::post('/admin/trip/add',[TripController::class,'addTrip']);

    Route::put('/admin/trip/update/{id}',[TripController::class,'updateTrip']);

    Route::delete('/admin/trip/delete/{id}',[TripController::class,'deleteTrip']);

/////////////////////////////////////////////// Car Categories ////////////////////////////////////////////

    Route::get('/admin/car_categories',[CarCategoryController::class,'getCategories']);

    Route::post('/admin/car_category/add',[CarCategoryController::class,'addCarCategories']);

    Route::put('/admin/car_category/update/{id}',[CarCategoryController::class,'updateCarCategories']);

    Route::delete('/admin/car_category/delete/{id}',[CarCategoryController::class,'deleteCarCategories']);

///////////////////////////////////////////// Car Brands /////////////////////////////////////////////////////

    Route::get('/admin/car_brands',[CarBrandController::class,'getBrands']);

    Route::post('/admin/car_brand/add',[CarBrandController::class,'addBrands']);

    Route::put('/admin/car_brand/update/{id}',[CarBrandController::class,'updateBrands']);

    Route::delete('/admin/car_brand/delete/{id}',[CarBrandController::class,'deleteBrands']);

//////////////////////////////////////////// Car Models /////////////////////////////////////////////////////

    Route::get('/admin/car_models',[CarModelController::class,'getModels']);

    Route::post('/admin/car_model/add',[CarModelController::class,'addCarModel']);

    Route::put('/admin/car_model/update/{id}',[CarModelController::class,'updateCarModel']);

    Route::delete('/admin/car_model/delete/{id}',[CarModelController::class,'deleteCarModel']);

///////////////////////////////////////////// Cars ///////////////////////////////////////////

    Route::get('/admin/cars',[AdminCarController::class,'getCar']);

    Route::post('/admin/car/add',[AdminCarController::class,'addCar']);

    Route::put('/admin/car/update/{id}',[AdminCarController::class,'updateCar']);

    Route::delete('/admin/car/delete/{id}',[AdminCarController::class,'deleteCar']);

    Route::get('/admin/agent_cars/{agent_id}',[AdminCarController::class,'getAgentCars']);

/////////////////////////////////////////// Train Type //////////////////////////////////////////////

    Route::get('/admin/trainTypes',[TrainTypeController::class,'getTypes']);

    Route::post('/admin/trainType/add',[TrainTypeController::class,'addType']);

    Route::put('/admin/trainType/update/{id}',[TrainTypeController::class,'updateType']);

    Route::delete('/admin/trainType/delete/{id}',[TrainTypeController::class,'deleteType']);

////////////////////////////////////////// Train Class //////////////////////////////////////////////

    Route::get('/admin/trainclasses',[TrainClassController::class,'getClasses']);

    Route::post('/admin/trainclass/add',[TrainClassController::class,'addClass']);

    Route::put('/admin/trainclass/update/{id}',[TrainClassController::class,'updateClass']);

    Route::delete('/admin/trainclass/delete/{id}',[TrainClassController::class,'deleteClass']);

////////////////////////////////////////// Train Route //////////////////////////////////////////////

    Route::get('/admin/trainRoutes',[TrainRouteController::class,'getRoutes']);

    Route::post('/admin/trainRoute/add',[TrainRouteController::class,'addRoute']);

    Route::put('/admin/trainRoute/update/{id}',[TrainRouteController::class,'updateRoute']);

    Route::delete('/admin/trainRoute/delete/{id}',[TrainRouteController::class,'deleteRoute']);

////////////////////////////////////////////// Train //////////////////////////////////////////////

    Route::get('/admin/trains',[TrainController::class,'getTrains']);

    Route::post('/admin/train/add',[TrainController::class,'addTrain']);

    Route::put('/admin/train/update/{id}',[TrainController::class,'modifyTrain']);

    Route::delete('/admin/train/delete/{id}',[TrainController::class,'deleteTrain']);

//////////////////////////////////////// Commission //////////////////////////////////////////////

    Route::get('/admin/AllCommissions',[CommissionController::class,'getAllCommission']);

    Route::get('/admin/CommissionAgent/{id}',[CommissionController::class,'getAgentCommission']);

    Route::post('/admin/CommissionDefault/add',[CommissionController::class,'addDefultCommission']);

    Route::post('/admin/CommissionAgent/add',[CommissionController::class,'addAgentCommission']);

    Route::get('/admin/defaultCommission',[CommissionController::class,'getDefaultCommission']);

    Route::put('/admin/defaultCommission/update/{id}',[CommissionController::class,'updateDefaultCommission']);

/////////////////////////////////////////////// operator Payment Method ////////////////////////////////////////////

    Route::get('/admin/operator_payment_methods',[OperatorPaymentMethodController::class,'getOperatorPaymentMetod']);

    Route::post('/admin/operator_payment_method/add',[OperatorPaymentMethodController::class,'addOperatorPaymentMethod']);

    Route::put('/admin/operator_payment_method/update/{id}',[OperatorPaymentMethodController::class,'updateOperatorPaymentMethod']);

    Route::delete('/admin/operator_payment_method/delete/{id}',[OperatorPaymentMethodController::class,'deleteOperatorPaymentMethod']);

//////////////////////////////////////////////////// Payout Request ////////////////////////////////////////////

    Route::put('/admin/payoutRequest/cancel/{id}',[PayoutController::class,'cancelPayout']);

    Route::get('/admin/payoutRequest',[PayoutController::class,'getPayoutRequest']);

    Route::put('/admin/payoutRequest/confirm/{id}',[PayoutController::class,'confirmPayout']);

    Route::get('/admin/payoutRequest/history',[PayoutController::class,'getHistoryPayout']);

    Route::get('/admin/canceledPayoutRequest',[PayoutController::class,'canceledPayoutRequest']);

////////////////////////////////////////////////// Fees ///////////////////////////////////////////////////////////

    Route::get('/admin/fees',[FeesController::class,'getFees']);

    Route::post('/admin/fees/add',[FeesController::class,'addFees']);

    Route::put('/admin/fees/update/{id}',[FeesController::class,'updateFees']);

    Route::delete('/admin/fees/delete/{id}',[FeesController::class,'deleteFees']);
});
