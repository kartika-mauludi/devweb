<?php

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
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
