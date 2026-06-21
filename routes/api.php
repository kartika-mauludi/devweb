<?php

use App\Http\Controllers\Api\ConfigFileController;
use App\Http\Controllers\AutoLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/config-files', [ConfigFileController::class, 'index']);


