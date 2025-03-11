<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    static $message = [
        'createsuccess' => 'Data berhasil ditambahkan',
        'updatesuccess' => 'Data berhasil diperbarui',
        'deletesuccess' => 'Data berhasil dihapus',
        'error' => 'Terjadi kesalahan sistem, hubungi administrator'
    ];
}
