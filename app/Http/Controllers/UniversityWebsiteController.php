<?php

namespace App\Http\Controllers;

use App\Models\UniversityWebsite;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
                if (!isset($item['title']) || !isset($item['url'])) {
                    echo json_encode(['status' => 400, 'message' => 'Format data tidak valid!']);
                    ob_flush();
                    flush();
                    return;
                }

                $record = UniversityWebsite::updateOrCreate(
                    ['university_id' => $universityId, 'title' => $item['title']],
                    ['url' => $item['url']]
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
}
