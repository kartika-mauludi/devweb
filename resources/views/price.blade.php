@extends('layouts.asset')

@section('content')



<main class="main my-5">

<section id="harga" class="pricing section light-background">
<!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
    <h2>PIlih Paket Langgangan</h2>
    <p></p>
    </div><!-- End Section Title -->
    <div class="container">
    <div class="row gy-4">
    @foreach($packages as $pack)
        <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="pricing-item">
            <h3>{{ $pack->name }}</h3>
            <span><s>Rp. {{ number_format($pack->discount , 0, ",", ".")}}</s></span>
            <h4><sup>Rp.</sup>{{ number_format($pack->price , 0, ",", ".")}}<span></span></h4>
            <small>Promo hemat untuk akses cepat selama sebulan penuh.</small>
            <ul>
            <li><i class="bi bi-check"></i> <span>Akses 700+ database riset premium</span></li>
            <li><i class="bi bi-check"></i> <span>Pembaruan otomatis</span></li>
            <li><i class="bi bi-check"></i> <span>Akses cepat ke database riset premium</span></li>
            <li><i class="bi bi-check"></i> <span>Bantuan fast respon</span></li>
            <li><i class="bi bi-check"></i> <span>Akses cepat ke database riset premium</span></li>
            @if($loop->iteration == "2")
            <li><i class="bi bi-check"></i> <span>Hemat 20% dibandingkan langganan bulanan</span></li>
            @elseif($loop->iteration == "3")
            <li><i class="bi bi-check"></i> <span>Hemat 33% dibandingkan langganan bulanan</span></li>
            @endif
            <a href="{{ route('payment',['id' => $pack->id, 'ref' => request('ref') ] ) }}" class="buy-btn">Pilih Paket</a>
        </div>
        </div><!-- End Pricing Item -->
    @endforeach
    </div>
          </div>
</section><!-- /Pricing Section -->

</main>




@endsection