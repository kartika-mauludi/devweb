<?php

use App\Http\Controllers\Admin\CustomerController;
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
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
