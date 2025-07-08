<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Bonus;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


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
        $data['bonuses'] = Bonus::all();
        $data['customers'] = User::where('is_superadmin','=',0)->get();
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
        $input = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'link' => 'nullable|url',
            'urut' => 'nullable',
            'file_location' => 'nullable|mimes:zip,jpg,jpeg,png'
        ]);
        
        $status = 400;
        $message = 'File gagal ditambahkan!';

        if ($request->has('file_location')) {
            if($request->type === "qris"){
                $input['file_location'] = $request->file('file_location')->storeAs('qris', $request->file('file_location')->getClientOriginalName(), ['disk' => 'public']);
            }else{
                $input['file_location'] = $request->file('file_location')->storeAs('extensi', $request->file('file_location')->getClientOriginalName(), ['disk' => 'public']);
            }
        }

        $result = file::create($input);
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
        $input = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'link' => 'nullable|url',
            'urut' => 'nullable|',
            'file_location' => 'nullable|mimes:zip,jpg,jpeg,png'
        ]);
        
        $status = 400;
        $message = 'File gagal diperbarui!';

        if ($request->has('file_location')) {
            $exist = Storage::disk('public')->exists($file->file_location ?? '--');
            if ($exist) {
                Storage::disk('public')->delete($file->file_location);
            }
            if($request->type === "qris"){
                $input['file_location'] = $request->file('file_location')->storeAs('qris', $request->file('file_location')->getClientOriginalName(), ['disk' => 'public']);
            }else{
                $input['file_location'] = $request->file('file_location')->storeAs('extensi', $request->file('file_location')->getClientOriginalName(), ['disk' => 'public']);
            }
        }

        $result = $file->update($input);

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
        $message = 'File gagal dihapus!';

        $exist = Storage::disk('public')->exists($file->file_location ?? '--');

        if ($exist) {
            Storage::disk('public')->delete($file->file_location);
        }
        
        if ($result) {
            $status = 200;
            $message = 'File berhasil dihapus!';
        }
    
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function data(){
        $file = file::select(['id', 'name', 'link', 'type', 'file_location','urut'])->get();
        return response()->json([
            "data" => $file
        ]);
    }

    public function databonus(){
        $file = bonus::with('user')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'file_location' => $item->file_location,
                'username' => $item->username,
                'password' => $item->password,
                'user_id' => $item->user_id,
                'customer' => $item->user->name ?? '-', // ini untuk kolom "Customer"
            ];
        });
        return response()->json([
            "data" => $file
        ]);
    }


    public function storebonus(request $request){
        $input = $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'username' => 'required',
            'password' => 'required',
            'file_location' => 'nullable|mimes:zip'
        ]);
        
        $status = 400;
        $message = 'File gagal ditambahkan!';

        if ($request->has('file_location')) {
            $input['file_location'] = $request->file('file_location')->storeAs('bonus', $request->file('file_location')->getClientOriginalName(), ['disk' => 'public']);
        }

        $result = bonus::create($input);
        if ($result) {
            $status = 200;
            $message = 'File berhasil ditambahkan!';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function editbonus(string $id){
        $file = bonus::findOrFail($id);
        return response()->json($file);
    }

    public function updatebonus(Request $request, bonus $bonus){
        $input = $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'username' => 'required',
            'password' => 'required',
            'file_location' => 'nullable|mimes:zip'
        ]);
        
        $status = 400;
        $message = 'File gagal diperbarui!';

        if ($request->has('file_location')) {
            $exist = Storage::disk('public')->exists($bonus->file_location ?? '--');
            if ($exist) {
                Storage::disk('public')->delete($bonus->file_location);
            }
            $input['file_location'] = $request->file('file_location')->storeAs('bonus', $request->file('file_location')->getClientOriginalName(), ['disk' => 'public']);  
            
        }

        $result = $bonus->update($input);

        if ($result) {
            $status = 200;
            $message = 'File berhasil diperbarui!';
        }
    
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function destroybonus(Bonus $bonus)
    {
        $result = $bonus->delete();

        $status = 400;
        $message = 'File gagal dihapus!';

        $exist = Storage::disk('public')->exists($bonus->file_location ?? '--');

        if ($exist) {
            Storage::disk('public')->delete($bonus->file_location);
        }
        
        if ($result) {
            $status = 200;
            $message = 'File berhasil dihapus!';
        }
    
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }



}
