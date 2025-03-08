<?php

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