<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Home\HomeController;
use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\BoxController;
use App\Http\Controllers\Dashboard\SubCategoryController;
use App\Http\Controllers\Dashboard\TicketController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\ContactUsController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\PloicyController;
use App\Http\Controllers\Dashboard\AdminTicketController;
use App\Http\Controllers\Dashboard\AdminTicketInfoController;
use App\Http\Controllers\Dashboard\CopounesController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PaymentController;
use App\Http\Controllers\Dashboard\UserTicketController;
use App\Http\Controllers\Dashboard\TicketRejectController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group( [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
    ], function () {

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', [AuthController::class, '_login'])->name('_login')->middleware('set.arabic.locale');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::middleware(['prevent-back-history','auth'])->group(function () {

        Route::resource('category', CategoryController::class);

        Route::resource('event', EventController::class);
        Route::get('eventstatus/{id}',[EventController::class ,'eventstatus'])->name('eventstatus');
        Route::get('users/active/{id}', [EventController::class, 'active']);

        Route::resource('event/{id}/box', BoxController::class);

        Route::resource('event/{id}/subcategory', SubCategoryController::class);

        Route::resource('userticket', TicketController::class);
        Route::post('ticket/accept' , [TicketController::class , 'ticketAccept'])->name('ticket.accept');
        Route::post('ticket/reject' , [TicketController::class , 'ticketReject'])->name('ticket.reject');
        Route::post('ticket/chanagedirectsale' , [TicketController::class , 'chanagedirectsale'])->name('ticket.chanagedirectsale');

        Route::resource('adminticket', AdminTicketController::class);
        Route::get('boxes/{id}',[AdminTicketController::class , 'getAllBoxes']);
        Route::get('subcategories/{id}',[AdminTicketController::class , 'getAllsubcategories']);
        Route::resource('ticket/{id}/info', AdminTicketInfoController::class);
        

        Route::resource('copounes', CopounesController::class);

        Route::resource('orders', OrderController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('user', UserController::class);
        Route::get('usersales/{id}',[UserController::class , 'getUserSales'])->name('user.sales');
        Route::get('userpurchases/{id}',[UserController::class , 'getUserPurchases'])->name('user.purchases');
        Route::post('ticket/convert/{id}' , [UserController::class , 'ticketconvert'])->name('ticket.convert');
        Route::resource('ticketreject', TicketRejectController::class);

        Route::resource('user/{id}/ticketuser', UserTicketController::class);

        Route::resource('contact-us', ContactUsController::class);

        Route::resource('commonquestion', QuestionController::class);

        Route::resource('policy', PloicyController::class);

        Route::get('setting', [SettingController::class , 'getpage'])->name('setting');
        Route::put('setting/update', [SettingController::class,'update'])->name('setting.update');

        Route::get('/', [HomeController::class, 'index'])->name('/');
    });

});
