@extends('customer.asset')

@section('content')


<section id="harga" class="pricing section light-background my-5">
<!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
    <h2>Paket</h2>
    </div><!-- End Section Title -->
    <div class="container">
    <div class="row gy-4">
    @foreach($packages as $pack)
    @if(!($pack->name == "custom" && $pack->id == 99 ))
        <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="pricing-item">
            <h3>{{ $pack->name }}</h3>
            <span><s>Rp. {{ number_format($pack->discount , 0, ",", ".")}}</s></span>
            <h4><sup>Rp.</sup>{{ number_format($pack->price , 0, ",", ".")}}<span></span></h4>
            <small>Promo hemat untuk akses cepat keberbagai database riset.</small>
            <ul>
            <li><i class="bi bi-check"></i> <span>Akses 700+ database riset premium</span></li>
            <li><i class="bi bi-check"></i> <span>Pembaruan otomatis</span></li>
            <li><i class="bi bi-check"></i> <span>Akses cepat ke database riset premium</span></li>
            <li><i class="bi bi-check"></i> <span>Bantuan fast respon</span></li>
            <li><i class="bi bi-check"></i> <span>Akses cepat ke database riset premium</span></li>
            @if($pack->id == "2")
            <li><i class="bi bi-check"></i> <span>Hemat 20% dibandingkan langganan bulanan</span></li>
            @elseif($pack->id == "3")
            <li><i class="bi bi-check"></i> <span>Hemat 33% dibandingkan langganan bulanan</span></li>
            @endif
            </ul>
            <a href="{{ route('customer/langganan.payment',$pack->id) }}" class="buy-btn">Pilih Paket</a>
        </div>
        </div><!-- End Pricing Item -->
        @if(!($pack->name == "custom" && $pack->id == 99 ))
    @endforeach
    
    </div>

    </div>

</section><!-- /Pricing Section -->




@endsection