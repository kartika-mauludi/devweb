<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UniversityAccount;
use App\Models\UniversityWebsite;

class AutoLoginController extends Controller
{

    public function getLoginData()
    {

        $akun = UniversityAccount::first();

        return response()->json($akun);
    }
}
