<?php

namespace App\Http\Controllers;

use App\Models\UniversityAccount;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function destroyAll($universityId)
    {
        $universityAccount = UniversityAccount::where('university_id', $universityId)
        ->get();

        if (count($universityAccount) <= 0) {
            return response()->json([
                'status' => 404,
                'message' => 'Akun tidak ditemukan!'
            ]);
        }

        try {
            foreach ($universityAccount as $account) {
                $users = User::whereNotNull('akun_id');

                $users->clone()->update([
                    'akun_id' => ''
                ]);
    
                $account->delete();

                // foreach ($users->clone()->get() as $user) {
                //     $this->sinkronakun($user);
                // }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Akun berhasil dihapus!'
            ]);
        } catch (Exception $x) {
            report($x);
            return response()->json([
                'status' => 400,
                'message' => 'Akun gagal dihapus!'
            ]);
        }

        return $this->sinkronuser([]);
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

    public function import(Request $request, $universityId)
    {
        $data = $request->input('data');

        if (!is_array($data) || empty($data)) {
            return response()->json(['status' => 400, 'message' => 'Data tidak valid!']);
        }

        $response = new StreamedResponse(function () use ($data, $universityId) {
            $insertedCount = 0;
            $updatedCount = 0;

            foreach ($data as $index => $item) {
                if (!isset($item['username']) || !isset($item['password'])) {
                    echo json_encode(['status' => 400, 'message' => 'Format data tidak valid!']);
                    ob_flush();
                    flush();
                    return;
                }

                $record = UniversityAccount::updateOrCreate(
                    ['university_id' => $universityId, 'username' => $item['username']],
                    ['password' => $item['password']]
                );

                if ($record->wasRecentlyCreated) {
                    $insertedCount++;
                } else {
                    $updatedCount++;
                }

                echo json_encode([
                    'status' => 200,
                    'message' => 'Mengimport data...',
                    'progress' => ($index + 1) . '/' . count($data),
                    'procesed' => $insertedCount + $updatedCount
                ]) . "\n";
                ob_flush();
                flush();
            }

            echo json_encode([
                'status' => 200,
                'message' => 'Import selesai!',
                'procesed' => $insertedCount + $updatedCount
            ]) . "\n";
            ob_flush();
            flush();
        });

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    // private function sinkronuser($user)
    // {
    //     $users    = User::customer()->pluck('akun_id');

    //     $counter = [];

    //     foreach ($users as $user) {
    //         if (is_array($user)) { 
    //             foreach ($user as $item) {
    //                 if (!isset($counter[$item])) {
    //                     $counter[$item] = 0;
    //                 }
    //                 $counter[$item]++;
    //             }
    //         }
    //     }

    //     $accounts = [];
    //     $items = [];
    //     foreach ($counter as $key => $item) {
    //         $account = UniversityAccount::find($key);
    //         array_push($items, $item);
    //         if ($account->university->batasan > $item) {
    //             array_push($accounts, $account);
    //         }
    //     }

    //     $data['accounts'] = $accounts;
    //     $data['counter']  = $counter;
    //     $data['items'] = $items;

    //     return $data;
    // }
}
