<?php

namespace App\Http\Controllers;

use App\Models\University;
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
        $data['records'] = University::all();

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
    
        University::create($request->all());
    
        return redirect()->route('universities.index')->with('message', 'Universitas berhasil ditambahkan!');
    }
    
    public function update(Request $request, University $university)
    {
        $request->validate([
            'name' => 'required',
            'main_url' => 'nullable|url',
            'signin_url' => 'nullable|url',
            'signout_url' => 'nullable|url',
        ]);
    
        $university->update($request->all());
    
        return redirect()->route('universities.index')->with('message', 'Universitas berhasil diperbarui!');
    }
    
    public function destroy(University $university)
    {
        $university->delete();
        return redirect()->route('universities.index')->with('message', 'Universitas berhasil dihapus!');
    }
    
}
