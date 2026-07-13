<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LynkWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        // 2. Simpan ke file log Laravel (storage/logs/laravel.log) untuk melihat isinya
        Log::info('Webhook Lynk.id Masuk:', $payload);

        // 3. Kembalikan response 200 OK agar Lynk.id tahu webhook berhasil diterima
        return response()->json(['message' => 'Webhook received'], 200);
    }
}
