@extends('customer.asset')

@section('content')

<main class="hero">
@if(!empty($payment->redirect_link) )
<iframe class="hero"src="{{ $payment->redirect_link }}" width="100%" height="900"></iframe>
@else
    <div class="alert alert-info alert-dismissible">
        <div class="container">
         Ada masalah ketika registrasi anda sehingga pembayaran anda tidak terdeteksi, silahkan hubungi admin atau klik menu langgalan untuk berlangganan <p>
            <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary my-2">Mulai Berlangganan</a>
          </p>
          </div>
    </div>
@endif

</main>


@endsection

