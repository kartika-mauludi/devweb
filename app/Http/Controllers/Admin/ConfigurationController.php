<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateComission;
use App\Models\AffiliateDetails;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationController extends Controller
{
    private $title = 'Master Konfigurasi';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['commisionsglobal'] = AffiliateComission::where('status','=','global')->first();
        $data['count'] = AffiliateComission::where('status','=','global')->get();
        $data['commisions'] = AffiliateComission::where('status','=','private')->latest()->get();
        return view('admin.configuration.index', $data);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['label'] = 'Tambah';
        $data['url']   = route('configuration.store');
        $data['prev']  = route('configuration.index');
        $data['users'] = User::customer()->get();
        $data['collections'] = [];
        
        return view('admin.configuration.form', $data);
    }

    public function store(Request $request)
    {
       
        DB::beginTransaction();
        try{
            if($request->status){
                $affiliates = AffiliateComission::create([
                    'amount' => $request->amount,
                    'type' => $request->type,
                    'status' => $request->status
                ]);
            }
            else{
                $affiliates = AffiliateComission::create([
                    'amount' => $request->amount,
                    'type' => $request->type,
                    'status' => 'private'
                ]);

                foreach ($request->users as $user) {
                    if ($user != null) {
                        AffiliateDetails::create([
                            'affiliate_comission_id' => $affiliates->id,
                            'user_id' => $user
                        ]);
                    }
                }
            }
            DB::commit();
            $message = $this::$message['createsuccess'];
        }catch(Exception $x){
            DB::rollBack();
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('configuration.index')->with('message', $message);
    }

    public function show($id)
    {
        $affiliate = AffiliateComission::find($id);

        $data['title'] = $this->title;
        $data['url']   = route('configuration.edit', $id);
        $data['prev']  = route('configuration.index');
        $data['record']= $affiliate;

        return view('admin.configuration.show', $data);
    }

    public function edit($id)
    {
        $affiliate = AffiliateComission::find(id: $id);

        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['url']   = route('configuration.update', $id);
        $data['prev']  = route('configuration.index');
        $data['users'] = User::customer()->get();
        $data['record']= $affiliate;
        $data['collections'] = AffiliateDetails::where('affiliate_comission_id', $id)->pluck('user_id')->toArray();
        // return $data['record']->status;
        return view('admin.configuration.form', $data);
    }

    public function update(Request $request, $id)
    {
        $affiliate = AffiliateComission::find($id);

        DB::beginTransaction();
        try{
            $affiliate->update([
                'amount' => $request->amount,
                'type' => $request->type
            ]);

            AffiliateDetails::where('affiliate_comission_id', $affiliate->id)->delete();

            foreach ($request->users as $user) {
                if ($user != null) {
                    AffiliateDetails::create([
                        'affiliate_comission_id' => $affiliate->id,
                        'user_id' => $user
                    ]);
                }
            }

            DB::commit();
            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            DB::rollBack();
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('configuration.index')->with('message', $message);
    }

    public function destroy($id)
    {
        $affiliate = AffiliateComission::find($id);

        try{
            $affiliate->delete();

            $message = $this::$message['deletesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('configuration.index')->with('message', $message);
    }

    public function destroyDetail($id)
    {
        $affiliate = AffiliateDetails::find($id);

        try{
            $affiliate->delete();

            $message = $this::$message['deletesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('configuration.show', $affiliate->affiliate_comission_id)->with('message', $message);
    }
}
