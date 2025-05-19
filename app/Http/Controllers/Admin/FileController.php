<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     private $title = 'Master File';

     public function __construct()
     {
         $this->middleware('admin');
     }
 
    public function index()
    {
        $data['title'] = $this->title;
        $data['files'] = File::all();
        return view('admin.file.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'link' => 'nullable|url',
        ]);
        
        $status = 400;
        $message = 'File gagal ditambahkan!';

        $result = file::create($request->all());
        if ($result) {
            $status = 200;
            $message = 'File berhasil ditambahkan!';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $file = File::findOrFail($id);
        return response()->json($file);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, file $file)
    {

        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'link' => 'nullable|url',
        ]);
        

        $status = 400;
        $message = 'File gagal diperbarui!';
    
        $result = $file->update($request->all());

        if ($result) {
            $status = 200;
            $message = 'File berhasil diperbarui!';
        }
    
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        $result = $file->delete();

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

    public function data(){
        $file = file::select(['id', 'name', 'link', 'type'])->get();
    
        return response()->json([
            "data" => $file
        ]);
    }
}
