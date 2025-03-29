<?php

namespace App\Http\Controllers;

use App\Models\UniversityWebsite;
use Illuminate\Http\Request;

class UniversityWebsiteController extends Controller
{
    public function store(Request $request, $universityId)
    {
        $request->validate([
            'website_id' => 'required|integer',
        ]);

        UniversityWebsite::create([
            'university_id' => $universityId,
            'website_id' => $request->website_id,
        ]);

        return redirect()->route('universities.show', $universityId);
    }
}
