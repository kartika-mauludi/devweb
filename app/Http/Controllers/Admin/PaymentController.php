<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\invoice;
use App\Models\Payment;
use App\Models\SubscribePackage;
use App\Models\SubscribeRecord;
use App\Models\UniversityAccount;
use App\Models\University;
use App\Models\User;
use App\Models\ConfigAdmin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Arr;
use App\Mail\info;
use App\Mail\notif;

class PaymentController extends Controller
{
    private $title = 'Master Pembayaran';
    // private $admin_email = ConfigAdmin::first()?->pluck('email');

    public function __construct()
    {
        $this->middleware('admin');
        $this->admin_email = User::with('config')->find(optional(ConfigAdmin::first())?->email)?->email;

    }

    public function index()
    {
        $data['title']   = $this->title;
        $data['records'] = Payment::latest()->get();
        
        return view('admin.payment.index', $data);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['label'] = 'Tambah';
        $data['url']   = route('payment.store');
        $data['prev']  = route('payment.index');
        $data['subscribeRecords'] = SubscribeRecord::all();

        return view('admin.payment.form', $data);
    }

    public function store(Request $request)
    {
        $subscribeRecord = SubscribeRecord::find($request->subscribe_record_id);
        $input = $request->except('_token');
        $input['user_id'] = $subscribeRecord->user_id;
        $input['discount']= ($request->filled('discount')) ? $request->discount : 0;

        try{
            Payment::create($input);

            $message = $this::$message['createsuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('payment.index')->with('message', $message);
    }

    public function show(Payment $payment)
    {
        $record = array(
            'id_invoice' => $payment->id_invoice,
            'user' => $payment->user->name ?? '',
            'package' => $payment->subscribeRecord->subscribePackage->name ?? '',
            'price' => $payment->price,
            'discount' => $payment->discount,
            'total' => $payment->grandtotal(),
            'status' => $payment->status
        );

        $data['url'] = route('payment.confirm', $payment->id);
        $data['record'] = $record;

        return response()->json($data);
    }

    public function edit(Payment $payment)
    {
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['url']   = route('payment.update', $payment->id);
        $data['prev']  = route('payment.index');
        $data['subscribeRecords'] = SubscribeRecord::all();
        $data['record']= $payment;

        return view('admin.payment.form', $data);
    }

    public function update(Request $request, Payment $payment)
    {
        $subscribeRecord = SubscribeRecord::find($request->subscribe_record_id);
        $input = $request->except('_token', '_method');
        $input['user_id'] = $subscribeRecord->user_id;
        $input['discount']= ($request->filled('discount')) ? $request->discount : 0;
        
        try{
            $payment->update($input);

            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('payment.index')->with('message', $message);
    }

    public function destroy(Payment $payment)
    {
        try{
            $payment->delete();

            $message = $this::$message['deletesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('payment.index')->with('message', $message);
    }

    public function confirm(Payment $payment)
    {
        $user = User::find($payment->user_id);
        if(empty($user->akun_id)){
            $univs = University::all();  
            if($univs->isEmpty()){
                $data ="Data Universitas masih belum di isi";
                Mail::to($this->admin_email ?? "afibrulyansah@unusa.ac.id" )->send(new notif($data));
            }

            foreach ($univs as $univ){
                $akun[] = $this->cek_id($univ->id);
                $univ_id[] = $univ->id;
            }

            if($a = array_keys($akun, null, true)){
                for($i = 0; $i < count($a); $i++){
                    $univid = $univ_id[$a[$i]];
                    $universiti[] = University::where('id',$univid)->pluck('name');
                }

                $data = $universiti;
                Mail::to($this->admin_email ?? "afibrulyansah@unusa.ac.id")->send(new info($data));

                $message = $this::$message['error_akun_univ'];
                return back()->with('error',$message)->withInput();
            }
        }


        DB::beginTransaction();
        try{
            $payment->update([
                'status' => 'completed'
            ]);
            if(empty($user->akun_id)){
                $user->update([
                    'akun_id' => $akun
                ]);
            }
            $subcribe = SubscribeRecord::where('id',$payment->subscribe_record_id)->first();
            $pack = SubscribePackage::where('id',$subcribe->subscribe_package_id)->first();
            $input['start_date'] = now();
            $input['end_date'] = now()->addDays((int) $pack->days);
            $input['account_status'] = 'aktif';
            $subcribe->update($input);

            SubscribeRecord::where('user_id', $payment->user_id)
            ->where('id', '!=', $subcribe->id)
            ->update(['account_status' => 'non-aktif']);
            DB::commit();
            $data = [
                'name' => $user->name,
                'email'=> $user->email,
                'invoice_id' => $payment->id_invoice,
                'paket' => $subcribe->subscribePackage->name,
                'start_date' => $subcribe->start_date,
                'end_date' => $subcribe->end_date,
                'price' => $subcribe->subscribePackage->price,
                'status' => 'completed'
            ];
            Mail::to($user->email)->send(new invoice($data));
            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            DB::rollBack();
            $message = $this::$message['error'];
        }

        return redirect()->route('payment.index')->with('message', $message);
    }

    private function cek_id($id_univ){

        $user_akun = User::all()->where('akun_id','!=','')->pluck('akun_id');
        $account = UniversityAccount::where('university_id',$id_univ)->pluck('id');
        $jumlah_akun = count($account);
        if(collect($user_akun)->flatten()->filter()->isEmpty()){
            $list_akun_univ = UniversityAccount::where('university_id',$id_univ)->pluck('id')->first();
            return $id_akun_univ = $list_akun_univ ;
    
        }else{  

              for($i = 0; $i <= $jumlah_akun; $i++){
                $universitas = University::where('id',$id_univ)->first();
              }
                $batas = $universitas->batasan;
                $akun_user_raw = User::where('akun_id', '!=', '')
                            ->pluck('akun_id')
                            ->toArray();

                $flattened = Arr::flatten($akun_user_raw);
                $account_id = array_values(array_unique($flattened));
                $count = array_count_values($flattened);
                $filtered = array_filter($count, function ($val, $id) use ($batas, $account) {
                    return $val < $batas && in_array($id, $account->toArray());
                }, ARRAY_FILTER_USE_BOTH);

                if (!empty($filtered)) {
                $next_available_id = array_key_first($filtered);
                return $next_available_id;
                } else {
                $account_used = array_unique($flattened); 
                $id_akun_univ = UniversityAccount::where('university_id', $id_univ)
                    ->whereNotIn('id', $account_used)
                    ->pluck('id')
                    ->first();

                return $id_akun_univ ?? null;
                }
         
        }
        
    }
}
