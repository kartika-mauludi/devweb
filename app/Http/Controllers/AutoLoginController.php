<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use App\Models\UniversityAccount;
use App\Models\UniversityWebsite;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;


class AutoLoginController extends Controller
{
    public function getAllowedUrls()
    {
        $urls = University::pluck('signin_url');

        return response()->json($urls);
    }

    public function getLoginData(Request $request)
    {
        $user = auth::user();

        // CEK PEMBAYARAN DAN PAKET YANG AKTIF
        $payments = Payment::latest('id')->where('user_id', $user->id)
        ->where('status', 'completed')
        ->whereHas('subscribeRecord', function ($query) {
            $query
                ->where('start_date', '<=', date('Y-m-d'))
                ->where('end_date', '>=', date('Y-m-d'));
        })
        ->with(['subscribeRecord.subscribePackage'])
        ->get();
    
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'Paket langganan tidak ditemukan'], 404);
        }    
        
        // CEK AKUN
        if (!$user->akun_id) {
            return response()->json(['message' => 'Akun belum ditambahkan, silahkan hubungi admin'], 404);
        }
        
        $accessUrl = $request->header('access_url');
        
        $parsedUrl = parse_url($accessUrl);
        
        $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];

        if ($parsedUrl['host'] == 'id.elsevier.com') {
            $pathuri = $parsedUrl['path'];
            $first = strpos($pathuri, '/');
            $second = strpos($pathuri, '/', $first + 1);

            $parsedPath = ($second != false) ? substr($pathuri, 0, $second + 1) : $pathuri;
            $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedPath;
        } elseif ($parsedUrl['host'] == 'login.uc.edu') {
            $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . '/idp/profile/SAML2/';
        }
        elseif ($parsedUrl['host'] == 'weblogin.asu.edu') {
            $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . '/cas/login';
        }
        else {
            $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
        }
        
        $query = University::whereRaw("signin_url LIKE ?", [$baseUrl . '%']);
        
        $university = $query->first();
    
        if (!$university) {
            return response()->json(['message' => 'University not found'], 404);
        }

        $akun = UniversityAccount::where([
            ['university_id', '=', $university->id]
        ])->whereIn('id', $user->akun_id)->first();        
        // dd($akun);
    
        return response()->json($akun);
    }
    
    

    
    
    
}
