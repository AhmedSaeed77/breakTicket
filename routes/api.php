<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\BankController;
use App\Http\Controllers\api\EventController;
use App\Http\Controllers\api\ContactUsController;
use App\Http\Controllers\api\SettingController;
use App\Http\Controllers\api\QuestionController;
use App\Http\Controllers\api\PolicyController;
use App\Http\Controllers\api\SocialController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\TicketController;
use App\Http\Controllers\api\UserDashboardController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'Lang'], function () {

Route::get('login/{provider}', [SocialController::class,'redirect']);
Route::get('/login/{provider}/callback',[SocialController::class,'Callback']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/reset', [UserController::class, 'reset']);
Route::post('/resetUserconfirm', [UserController::class, 'resetUserconfirm']);
Route::post('/changePassword', [UserController::class, 'changePassword']);

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'logged out succefully']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('user/info', [UserController::class, 'getuserinfo']);
    Route::get('user/profile', [UserController::class, 'getuserprofile']);
    Route::post('update/profile', [UserController::class, 'updateprofile']);

    Route::post('update/changepassword', [UserController::class, 'updatechangepassword']);

    Route::get('bankAccount', [BankController::class, 'getBankAccount']);
    Route::post('bank/store', [BankController::class, 'store']);
    Route::post('bank/update', [BankController::class, 'update']);

    Route::post('ticket/store', [TicketController::class, 'store']);

    Route::post('add/cart', [CartController::class, 'addToCart']);
    Route::get('getAllTicketsCart', [CartController::class, 'getAllTicketsCart']);
    Route::delete('delete/cart/{id}', [CartController::class, 'deleteFromCart']);

    Route::get('getAllTicketsForUser', [UserDashboardController::class, 'getAllTicketsForUser']);
    Route::get('getOneTicketsForUser/{id}', [UserDashboardController::class, 'getOneTicketsForUser']);
    Route::post('cancelTicket', [UserDashboardController::class, 'cancelTicket']);
    Route::post('changePriceOfTicket', [UserDashboardController::class, 'changePriceOfTicket']);
    Route::post('changeimage', [UserDashboardController::class, 'changeimage']);

    Route::get('getAllTicketsSalledForUser', [UserDashboardController::class, 'getAllTicketsSalledForUser']);
    Route::get('getOneTicketSalledForUser/{id}', [UserDashboardController::class, 'getOneTicketSalledForUser']);

    Route::get('getAllTicketsWantToSalle', [UserDashboardController::class, 'getAllTicketsWantToSalle']);
    Route::get('getOneTicketsWantToSalle/{id}', [UserDashboardController::class, 'getOneTicketsWantToSalle']);

    Route::get('getAllNewTickets', [UserDashboardController::class, 'getAllNewTickets']);
    Route::get('getOneNewTickets/{id}', [UserDashboardController::class, 'getOneNewTickets']);

    Route::post('acceptReject', [UserDashboardController::class, 'acceptReject']);

    Route::get('getAllOrderWallet', [UserDashboardController::class, 'getAllOrderWallet']);
    Route::get('getOnerderWallet/{id}', [UserDashboardController::class, 'getOnerderWallet']);

    Route::post('check/copoune', [OrderController::class, 'checkCopoune']);
    Route::post('create/order', [OrderController::class, 'createOrder']);

    Route::post('create/fasterorder', [OrderController::class, 'createFasterOrder']);
    Route::get('gettotalpricefasterorder', [OrderController::class, 'gettotalpricefasterorder']);

    Route::post('create/payment', [PaymentController::class, 'createPayment']);

    Route::post('electronic/payment', [PaymentController::class, 'electronic_payment'])->name('electronic_payment');
    Route::post('electronic/payment/callback', [PaymentController::class, 'electronicCallback'])->name('electronicCallback');
    Route::post('webhook', [PaymentController::class, 'webhook'])->name('electronic_payment_webhook');

    Route::post('payment/checkout_id', [PaymentController::class, 'getCheckoutId']);
    Route::post('payment/checkout_details', [PaymentController::class, 'getCheckoutDetails']);

});

Route::get('ticket/quantity/{id}', [TicketController::class, 'getAllQuantityForTicket']);
Route::get('ticket/subcategory/{id}', [TicketController::class, 'getAllSubcategoryForTicket']);
Route::get('ticket/box/{id}', [TicketController::class, 'getAllBoxForTicket']);
Route::post('ticket/filter', [TicketController::class, 'filter']);

Route::get('categories', [CategoryController::class, 'getAllCategories']);

Route::get('events', [EventController::class, 'getAllEvents']);
Route::get('popularevents', [EventController::class, 'popularevents']);
Route::get('getAllEventsByCategory/{id}', [EventController::class, 'getAllEventsByCategory']);
Route::get('event/{id}', [EventController::class, 'getOneEvent']);
Route::post('search', [EventController::class, 'search']);
Route::post('event/filter', [EventController::class, 'filter']);


Route::get('getContactusData', [ContactUsController::class, 'getContactusData']);
Route::post('contact-us', [ContactUsController::class, 'store']);

Route::get('getwhoAreYouData', [SettingController::class, 'getwhoAreYouData']);
Route::get('getFooterData', [SettingController::class, 'getFooterData']);

Route::get('getCommonQuestions', [QuestionController::class, 'getCommonQuestions']);

Route::get('getAllPolicies', [PolicyController::class, 'getAllPolicies']);

Route::get('getBankInfo', [SettingController::class, 'getBankInfo']);

});
