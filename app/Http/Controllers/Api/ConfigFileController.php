<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ConfigFileController extends Controller
{
    public function index()
    {
        // ambil semua file di folder itu (mengembalikan path seperti "public/config_files/name.ext")
        $files = Storage::disk('public')->files('config');

        // dd($files);

        $list = [];
        // dd(file_exists("D:\\WORK\\devweb\\storage\\app\\public\\config\\config.enc"));
        foreach ($files as $file) {
            $basename = basename($file);
            $publicUrl = Storage::url($file);
            $absoluteUrl = url($publicUrl, [], true);

            // Pastikan path benar di Windows
            $normalizedFile = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $file);
            $localPath = storage_path('app/public/' . $file);
            // dd($localPath);
            // dd(file_exists($localPath));
            if (file_exists($localPath)) {
                $hash = hash_file('sha256', $localPath);
                $mtime = filemtime($localPath);
            } else {
                $hash = null;
                $mtime = null;
            }

            $list[] = [
                'name'       => $basename,
                'url'        => $absoluteUrl,
                'hash'       => $hash,
                'updated_at' => $mtime,
            ];
        }

        return response()->json($list);
    }
}
