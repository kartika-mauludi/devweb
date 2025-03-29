<?php

namespace App\Http\Controllers;

use App\Models\UniversityAccount;
use Illuminate\Http\Request;

class UniversityAccountController extends Controller
{
    public function store(Request $request, $universityId)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        UniversityAccount::create([
            'university_id' => $universityId,
            'username' => $request->username,
            'password' => $request->password,
        ]);

        return redirect()->route('universities.show', $universityId);
    }

}
