<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Models\UniversityAccount;
use App\Models\UniversityWebsite;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    private $title = 'Master Universitas';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data['title']   = $this->title;

        return view('admin.universities.index', $data);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'main_url' => 'nullable|url',
            'signin_url' => 'nullable|url',
            'signout_url' => 'nullable|url',
        ]);

        if (University::where('name', $request->name)->exists()) {
            return response()->json([
                'status' => 403,
                'message' => 'Nama universitas sudah ada!'
            ]);
        }
        
        $status = 400;
        $message = 'Universitas gagal ditambahkan!';

        $result = University::create($request->all());
        if ($result) {
            $status = 200;
            $message = 'Universitas berhasil ditambahkan!';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
    
    public function update(Request $request, University $university)
    {
        $request->validate([
            'name' => 'required',
            'main_url' => 'nullable|url',
            'signin_url' => 'nullable|url',
            'signout_url' => 'nullable|url',
        ]);

        if (University::where('name', $request->name)
            ->where('id', '!=', $university->id)
            ->exists()) {
            return response()->json([
                'status' => 403,
                'message' => 'Nama universitas sudah ada!'
            ]);
        }

        $status = 400;
        $message = 'Universitas gagal diperbarui!';
    
        $result = $university->update($request->all());

        if ($result) {
            $status = 200;
            $message = 'Universitas berhasil diperbarui!';
        }
    
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
    
    public function destroy(University $university)
    {
        // return $university;
        $result = $university->delete();

        $status = 400;
        $message = 'Universitas gagal dihapus!';
        
        if ($result) {
            $status = 200;
            $message = 'Universitas berhasil dihapus!';
        }
    
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }    

    public function edit($id)
    {
        $university = University::findOrFail($id);
        return response()->json($university);
    }
    
    
    public function show($id)
    {
        $data['title'] = $this->title;
        $data['university'] = University::findOrFail($id);
    
        return view('admin.universities.detail', $data);
    }

    public function getData()
    {
        $universities = University::select(['id', 'name', 'main_url', 'signin_url', 'signout_url'])->get();
    
        return response()->json([
            "data" => $universities
        ]);
    }
}
