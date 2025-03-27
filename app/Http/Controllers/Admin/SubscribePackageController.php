<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscribePackage;
use Exception;
use Illuminate\Http\Request;

class SubscribePackageController extends Controller
{
    private $title = 'Master Paket Langganan';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data['title']   = $this->title;
        $data['records'] = SubscribePackage::all();

        return view('admin.package.index', $data);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['label'] = 'Tambah';
        $data['url']   = route('package.store');
        $data['prev']  = route('package.index');

        return view('admin.package.form', $data);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');

        $records = SubscribePackage::all();

        if (count($records) >= 3) {
            return redirect()->route('package.index')->with('message', 'Maximum capacity is reached');
        }

        try{
            SubscribePackage::create($input);

            $message = $this::$message['createsuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('package.index')->with('message', $message);
    }

    public function show(SubscribePackage $subscribePackage)
    {
        $data['title']  = $this->title;
        $data['url']   = route('package.edit', $subscribePackage->id);
        $data['prev']  = route('package.index');
        $data['record'] = $subscribePackage;

        return view('admin.package.show', $data);
    }

    public function edit(SubscribePackage $subscribePackage)
    {
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['url']   = route('package.update', $subscribePackage->id);
        $data['prev']  = route('package.index');
        $data['record']= $subscribePackage;

        return view('admin.package.form', $data);
    }

    public function update(Request $request, SubscribePackage $subscribePackage)
    {
        $input = $request->except('_token', '_method');

        try{
            $subscribePackage->update($input);

            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('package.index')->with('message', $message);
    }

    public function destroy(SubscribePackage $subscribePackage)
    {
        try{
            $subscribePackage->delete();

            $message = $this::$message['deletesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('package.index')->with('message', $message);
    }
}
