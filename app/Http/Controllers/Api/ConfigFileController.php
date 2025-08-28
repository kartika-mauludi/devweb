<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ConfigFileController extends Controller
{
    public function index()
    {
        $files = Storage::disk('public')->files('config');

        $list = [];
        foreach ($files as $file) {
            $publicUrl = Storage::url($file);
            $absoluteUrl = asset('/devweb/public/storage/'. $file);
            $localPath = Storage::disk('public')->path($file); // /devweb/public/storage/config/config.enc

            if (file_exists($localPath)) {
                $hash = hash_file('sha256', $localPath);
                $mtime = filemtime($localPath);
            } else {
                $hash = null;
                $mtime = null;
            }

            $list[] = [
                'name'       => basename($file),
                'url'        => $absoluteUrl,
                'hash'       => $hash,
                'updated_at' => $mtime,
            ];
        }

        // /devweb/public/storage/config/config.enc

        return response()->json($list);
    }
}
