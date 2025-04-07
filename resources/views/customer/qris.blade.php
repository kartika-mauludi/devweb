@extends('customer.asset')

@section('content')



<main class="hero">
@if(!empty($payment->redirect_link) )
<section id="tabel" class="services section light-background">
    <div class="alert alert-info alert-dismissible">
        <div class="container">
         Ada masalah ketika registrasi anda sehingga pembayaran anda tidak terdeteksi, silahkan hubungi admin atau klik menu langgalan untuk berlangganan <p>
            <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary my-2">Mulai Berlangganan</a>
          </p>
          </div>
    </div>
</section>
@endif


</main>


@endsection

