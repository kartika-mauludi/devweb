<?php

namespace App\Http\Controllers;

use App\Models\UniversityAccount;
use Illuminate\Http\Request;

class UniversityAccountController extends Controller
{
    public function index($universityId)
    {
        $accounts = UniversityAccount::where('university_id', $universityId)->get();
        return response()->json([
            "data" => $accounts 
        ]);
    }
    
    public function store(Request $request, $universityId)
    {
        $request->validate([
            // 'university_id' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        if (UniversityAccount::where('username', $request->username)
            ->where('university_id', $universityId)
            ->exists()) {
            return response()->json([
                'status' => 403,
                'message' => 'Nama akun tersebut sudah ada di universitas ini!'
            ]);
        }

        $result = UniversityAccount::create([
            'university_id' => $universityId,
            'username' => $request->username,
            'password' => $request->password
        ]);
    
        $status = 400;
        $message = 'Akun gagal ditambahkan!';

        if ($result) {
            $status = 200;
            $message = 'Akun berhasil ditambahkan!';
        }
    
        return response()->json([
            'status' => $status, 
            'message' => $message
        ]);
    }
    
    public function destroy($universityId, $accountId)
    {
        $universityAccount = UniversityAccount::where('university_id', $universityId)
                                              ->where('id', $accountId)
                                              ->first();
    
        if (!$universityAccount) {
            return response()->json([
                'status' => 404,
                'message' => 'Akun tidak ditemukan!'
            ]);
        }
    
        if ($universityAccount->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Akun berhasil dihapus!'
            ]);
        }
    
        return response()->json([
            'status' => 400,
            'message' => 'Akun gagal dihapus!'
        ]);
    }
    

    public function edit($university_id, $account_id)
    {
        $account = UniversityAccount::where('university_id', $university_id)
                                    ->where('id', $account_id)
                                    ->firstOrFail();

        return response()->json($account);
    }


    public function update(Request $request, $universityId, $accountId)
    {
        $request->validate([
            // 'university_id' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        if (UniversityAccount::where('username', $request->username)
            ->where('university_id', $universityId)
            ->where('id', '!=', $accountId)
            ->exists()) {
            return response()->json([
                'status' => 403,
                'message' => 'Nama akun sudah ada di universitas ini!'
            ]);
        }

        $account = UniversityAccount::where('id', $accountId)->where('university_id', $universityId)->firstOrFail();
        $result = $account->update([
            'username' => $request->username,
            'password' => $request->password
        ]);

        $status = 400;
        $message = 'Akun gagal diperbarui!';

        if ($result) {
            $status = 200;
            $message = 'Akun berhasil diperbarui!';
        }
    
        return response()->json([
            'status' => $status, 
            'message' => $message
        ]);
    }

    

}
