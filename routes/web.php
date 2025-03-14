<?php

use App\Http\Controllers\Admin\AffiliateCommisionController;
use App\Http\Controllers\Admin\ConfigurationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MidtransConfigController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SubscribePackageController;
use App\Http\Controllers\Admin\SubscribeRecordController;
use App\Http\Controllers\Admin\SuperadminController;
use App\Http\Controllers\Admin\UserAffiliateController;
use Illuminate\Support\Facades\Route;
use App\Models\SubscribePackage;

Route::get('/', function () {
    $packages =  SubscribePackage::all();
    return view('welcome',compact('packages'));
});

Auth::routes();

Route::get('/payment/{id}','App\Http\Controllers\PaymentController@index')->name('payment');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminhome'])->name("admin.home");
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/home', [App\Http\Controllers\HomeController::class, 'userhome'])->name("user.home");
});

// Start Admin Page Routes //

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'customer', 'as' => 'customer.', 'controller' => CustomerController::class], function(){
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::get('show/{user}', 'show')->name('show');
    Route::get('edit/{user}', 'edit')->name('edit');

    Route::post('store', 'store')->name('store');
    Route::put('update/{user}', 'update')->name('update');
    Route::delete('destroy/{user}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.', 'controller' => SuperadminController::class], function(){
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::get('show/{user}', 'show')->name('show');
    Route::get('edit/{user}', 'edit')->name('edit');

    Route::post('store', 'store')->name('store');
    Route::put('update/{user}', 'update')->name('update');
    Route::delete('destroy/{user}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'package', 'as' => 'package.', 'controller' => SubscribePackageController::class], function(){
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::get('edit/{subscribePackage}', 'edit')->name('edit');

    Route::post('store', 'store')->name('store');
    Route::put('update/{subscribePackage}', 'update')->name('update');
    Route::delete('destroy/{subscribePackage}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'package-record', 'as' => 'package-record.', 'controller' => SubscribeRecordController::class], function(){
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::get('edit/{subscribeRecord}', 'edit')->name('edit');

    Route::post('store', 'store')->name('store');
    Route::put('update/{subscribeRecord}', 'update')->name('update');
    Route::delete('destroy/{subscribeRecord}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'user-affiliates', 'as' => 'user-affiliates.', 'controller' => UserAffiliateController::class], function(){
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::get('edit/{userAffiliate}', 'edit')->name('edit');
    Route::get('proceed/{userAffiliate}', 'proceed')->name('proceed');

    Route::post('store', 'store')->name('store');
    Route::put('update/{userAffiliate}', 'update')->name('update');
    Route::delete('destroy/{userAffiliate}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'payment', 'as' => 'payment.', 'controller' => PaymentController::class], function(){
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::get('show/{payment}', 'show')->name('show');
    Route::get('edit/{payment}', 'edit')->name('edit');

    Route::post('store', 'store')->name('store');
    Route::put('update/{payment}', 'update')->name('update');
    Route::delete('destroy/{payment}', 'destroy')->name('destroy');
});

Route::get('configuration', [ConfigurationController::class, 'index'])->name('configuration');

Route::group(['prefix' => 'commision-config', 'as' => 'commision-config.', 'controller' => AffiliateCommisionController::class], function(){
    Route::get('setting', 'setting')->name('setting');
    Route::post('store', 'store')->name('store');
});

Route::group(['prefix' => 'midtrans-config', 'as' => 'midtrans-config.', 'controller' => MidtransConfigController::class], function(){
    Route::get('setting', 'setting')->name('setting');
    Route::post('store', 'store')->name('store');
});

// End Admin Page Route //
