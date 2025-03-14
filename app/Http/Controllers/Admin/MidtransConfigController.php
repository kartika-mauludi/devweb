<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MidtranConfig;
use Exception;
use Illuminate\Http\Request;

class MidtransConfigController extends Controller
{
    private $title = 'Konfigurasi Midtrans';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function setting()
    {
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['url']   = route('midtrans-config.store');
        $data['prev']  = route('configuration');
        $data['record']= MidtranConfig::first();

        return view('admin.midtrans.form', $data);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token', 'Id');

        try{
            MidtranConfig::updateOrCreate(['id' => $request->Id], $input);

            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('configuration')->with('message', $message);
    }
}