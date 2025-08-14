<?php

use App\Http\Controllers\Api\ConfigFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/config-files', [ConfigFileController::class, 'index']);
