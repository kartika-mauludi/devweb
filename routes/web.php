<?php

use App\Http\Controllers\Admin\AffiliateCommisionController;
use App\Http\Controllers\Admin\ConfigurationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SubscribePackageController;
use App\Http\Controllers\Admin\UserAffiliateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminhome'])->name("admin.home");
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/home', [App\Http\Controllers\HomeController::class, 'userhome'])->name("user.home");
});

Route::group(['prefix' => 'customer', 'as' => 'customer.', 'controller' => CustomerController::class], function(){
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
    Route::get('show/{subscribePackage}', 'show')->name('show');
    Route::get('edit/{subscribePackage}', 'edit')->name('edit');

    Route::post('store', 'store')->name('store');
    Route::put('update/{subscribePackage}', 'update')->name('update');
    Route::delete('destroy/{subscribePackage}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'user-affiliates', 'as' => 'user-affiliates.', 'controller' => UserAffiliateController::class], function(){
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::get('show/{userAffiliate}', 'show')->name('show');
    Route::get('edit/{userAffiliate}', 'edit')->name('edit');
    Route::get('proceed/{userAffiliate}', 'proceed')->name('proceed');

    Route::post('store', 'store')->name('store');
    Route::put('update/{userAffiliate}', 'update')->name('update');
    Route::delete('destroy/{userAffiliate}', 'destroy')->name('destroy');
});

Route::get('configuration', [ConfigurationController::class, 'index'])->name('configuration');

Route::group(['prefix' => 'commision-config', 'as' => 'commision-config.', 'controller' => AffiliateCommisionController::class], function(){
    Route::get('setting', 'setting')->name('setting');

    Route::post('store', 'store')->name('store');
});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
