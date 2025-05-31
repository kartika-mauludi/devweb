<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    static $message = [
        'extendsuccess' => 'Langganan Anda Berhasi Di Perpanjang',
        'createsuccess' => 'Data berhasil ditambahkan',
        'updatesuccess' => 'Data berhasil diperbarui',
        'deletesuccess' => 'Data berhasil dihapus',
        'error' => 'Terjadi kesalahan sistem, hubungi administrator',
        'error_payment' => 'Terjadi kesalahan pada pembayaran, hubungi administrator',
        'error_register' => 'Terjadi kesalahan pada menu register, hubungi administrator',
        'error_akun_univ' => 'Terjadi kesalahan, hubungi administrator',
        'sukses' => 'Pembayaran berhasil'
    ];
}
