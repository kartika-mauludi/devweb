<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use App\Models\UniversityAccount;
use App\Models\UniversityWebsite;
use Illuminate\Support\Facades\Log;

class AutoLoginController extends Controller
{

    public function getAllowedUrls()
    {
        $urls = UniversityWebsite::pluck('url');

        return response()->json($urls);
    }

    public function getLoginData(Request $request)
    {
        $accessUrl = $request->header('access_url');
        
        $parsedUrl = parse_url($accessUrl);
        
        $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
        
        $query = University::whereRaw("signin_url LIKE ?", [$baseUrl . '%']);
        
        $university = $query->first();
    
        if (!$university) {
            return response()->json(['message' => 'University not found'], 404);
        }

        $akun = UniversityAccount::where('university_id', $university->id)->first();
    
        return response()->json($akun);
    }
    
    

    
    
    
}
