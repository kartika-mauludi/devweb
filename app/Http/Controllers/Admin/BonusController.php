<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BonusesDetails;
use Illuminate\Http\Request;
use App\Models\Bonus;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class BonusController extends Controller
{
    private $title = 'Master Bonus';

    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = $this->title;
        $data['bonuses'] = Bonus::all();
        $data['count'] = Bonus::where('type','=','global')->get();
        $data['customers'] = User::where('is_superadmin','=',0)->get();
        $data['users'] = User::customer()->get();
        $data['collections'] = [];
        $data['id_global'] = Bonus::where('type','=','global')->pluck('id')->first();
        return view('admin.Bonus.index',$data);
    }

    public function count()
    {
        $count = Bonus::where('type','=','global')->count();
        $id_global= Bonus::where('type','=','global')->pluck('id')->first();

        return response()->json(['count' => $count, 'id_global' =>$id_global]);
    }

    public function databonusglobal(){
        $file = bonus::where('type','=','global')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'file_location' => $item->file_location,
                'username' => $item->username,
                'password' => $item->password,
                'customer' => $item->user->name ?? '-', // ini untuk kolom "Customer"
            ];
        });
        return response()->json([
            "data" => $file
        ]);
    }

    public function databonusprivate(){
        $file = bonus::where('type','=','private')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'file_location' => $item->file_location,
                'username' => $item->username,
                'password' => $item->password,
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
            'username' => 'required',
            'password' => 'required',
            'type' => 'required',
            'file_location' => 'nullable|mimes:zip'
        ]);
        
        $status = 400;
        $message = 'File gagal ditambahkan!';

        if ($request->has('file_location')) {
            $input['file_location'] = $request->file('file_location')->storeAs('bonus', $request->file('file_location')->getClientOriginalName(), ['disk' => 'public']);
        }

        $result = bonus::create($input);

        if($result && $request->type === "private"){
            foreach ($request->users as $user) {
                if ($user != null) {
                    BonusesDetails::create([
                        'bonuses_id' => $result->id,
                        'user_id' => $user
                    ]);
                }
            }
        }
        if ($result) {
            $status = 200;
            $message = 'File berhasil ditambahkan!';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function showbonus(string $id)
    {
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['record'] = bonus::findOrFail($id);
        $data['url'] =route('bonus.edit-bonus', $id);
        $data['prev']  = route('bonus.index');
        $data['users'] = User::customer()->get();
        $data['collections'] = BonusesDetails::where('bonuses_id', $id)->pluck('user_id')->toArray();
       
        // return $data['collections'];
        return view('admin.Bonus.show',$data);
    }


    public function editbonus(string $id){
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['bonus'] = bonus::findOrFail($id);
        $data['url'] =route('bonus.update-bonus', $id);
        $data['prev']  = route('bonus.index');
        $data['users'] = User::customer()->get();
        $data['collections'] = BonusesDetails::where('bonuses_id', $id)->pluck('user_id')->toArray();
        // return $data['collections'];
        return view('admin.Bonus.form',$data);
    }

    public function updatebonus(Request $request, bonus $bonus){

        $input = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'file_location' => 'nullable|mimes:zip'
        ]);
        
        DB::beginTransaction();
        try{
           $bonus->update($input);
        if($bonus->type == "private"){
            BonusesDetails::where('bonuses_id', $bonus->id)->delete();
            foreach ($request->users as $user) {
                if ($user != null) {
                    BonusesDetails::create([
                        'bonuses_id' => $bonus->id,
                        'user_id' => $user
                    ]);
                }
            }
        }
        if ($request->has('file_location') && $request->file_location != Null) {
            $exist = Storage::disk('public')->exists($bonus->file_location ?? '--');
            if ($exist) {
                Storage::disk('public')->delete($bonus->file_location);
            }
            $input['file_location'] = $request->file('file_location')->storeAs('bonus', $request->file('file_location')->getClientOriginalName(), ['disk' => 'public']);  
            
        }

            DB::commit();
            $message = $this::$message['updatesuccess'];
            }catch(Exception $x){
                DB::rollBack();
                report($x);
                $message = $this::$message['error'];
            }

        return redirect()->route('bonus.index')->with('message', $message);

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

    public function destroyDetail($id)
    {
        $bonus = BonusesDetails::find($id);

        try{
            $bonus->delete();

            $message = $this::$message['deletesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('bonus.show-bonus', $bonus->bonuses_id)->with('message', $message);
    }

}
