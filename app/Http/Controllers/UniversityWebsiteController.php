<?php

namespace App\Http\Controllers;

use App\Models\UniversityWebsite;
use Illuminate\Http\Request;

class UniversityWebsiteController extends Controller
{
    public function index($universityId)
    {
        $websites = UniversityWebsite::where('university_id', $universityId)->get();
        return response()->json([
            "data" => $websites
        ]);
    }
    
    public function store(Request $request, $universityId)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required',
        ]);

        if (UniversityWebsite::where('title', $request->title)
            ->where('university_id', $universityId)
            ->exists()) {
            return response()->json([
                'status' => 403,
                'message' => 'Judul website tersebut sudah ada di universitas ini!'
            ]);
        }

        $result = UniversityWebsite::create([
            'university_id' => $universityId,
            'title' => $request->title,
            'url' => $request->url
        ]);

        $status = 400;
        $message = 'Website gagal ditambahkan!';

        if ($result) {
            $status = 200;
            $message = 'Website berhasil ditambahkan!';
        }
    
        return response()->json([
            'status' => $status, 
            'message' => $message
        ]);
    }
    
    public function destroy($universityId, $websiteId)
    {
        UniversityWebsite::where('id', $websiteId)->delete();
        return response()->json(['success' => 'Website berhasil dihapus']);
    }

    public function edit($university_id, $account_id)
    {
        $account = UniversityWebsite::where('university_id', $university_id)
                                    ->where('id', $account_id)
                                    ->firstOrFail();

        return response()->json($account);
    }
    
    public function update(Request $request, $universityId, $websiteId)
    {
        $request->validate([
            'title' => 'required',
            'url' => 'required',
        ]);

        $website = UniversityWebsite::where('id', $websiteId)->where('university_id', $universityId)->firstOrFail();
        
        $result = $website->update([
            'title' => $request->title,
            'url' => $request->url
        ]);

        $status = 400;
        $message = 'Website gagal diperbarui!';

        if ($result) {
            $status = 200;
            $message = 'Website berhasil diperbarui!';
        }
    
        return response()->json([
            'status' => $status, 
            'message' => $message
        ]);
    }

}
