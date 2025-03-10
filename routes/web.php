<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'Admin'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'adminhome'])->name('home');
});

Route::middleware(['auth', 'User'])->group(function () {
    Route::get('/home2', [App\Http\Controllers\HomeController::class, 'userhome'])->name('home2');
});