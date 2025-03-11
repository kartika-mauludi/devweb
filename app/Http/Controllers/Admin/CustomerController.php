<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    private $title = 'Master Customer';

    public function __construct()
    {
        // $this->middleware('admin');
    }

    public function index()
    {
        $data['title']   = $this->title;
        $data['records'] = User::customer()->get();

        return view('admin.customer.index', $data);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['label'] = 'Tambah';
        $data['url']   = route('customer.store');
        $data['prev']  = route('customer.index');

        return view('admin.customer.form', $data);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        $input['referral_code'] = Str::random(10);
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        try{
            User::create($input);

            $message = $this::$message['createsuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('customer.index')->with('message', $message);
    }

    public function show(User $user)
    {
        $data['title']  = $this->title;
        $data['url']   = route('customer.edit', $user->id);
        $data['prev']  = route('customer.index');
        $data['record'] = $user;

        return view('admin.customer.show', $data);
    }

    public function edit(User $user)
    {
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['url']   = route('customer.update', $user->id);
        $data['prev']  = route('customer.index');
        $data['record']= $user;

        return view('admin.customer.form', $data);
    }

    public function update(Request $request, User $user)
    {
        $input = $request->except('_token', '_method', 'password');
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        try{
            $user->update($input);

            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('customer.index')->with('message', $message);
    }

    public function destroy(User $user)
    {
        try{
            $user->delete();

            $message = $this::$message['deletesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('customer.index')->with('message', $message);
    }
}
