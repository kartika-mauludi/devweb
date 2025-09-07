<?php

use App\Http\Controllers\Api\ConfigFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/config-files', [ConfigFileController::class, 'index']);

Route::post('/version-check', function (\Illuminate\Http\Request $request) {
    $minVersion = '1.0.0';
    $current = $request->header('X-Extension-Version');

    if (!$current || version_compare($current, $minVersion, '<')) {
        return response()->json([
            'status' => 'blocked',
            'message' => 'Versi ekstensi lama. Fitur dimatikan.',
        ], 403);
    }

    return response()->json([
        'status' => 'ok',
        'message' => 'Versi valid, fitur boleh digunakan.',
    ]);
});