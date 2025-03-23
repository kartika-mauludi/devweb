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
        <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="pricing-item">
            <h3>{{ $pack->name }}</h3>
            <h4><sup>Rp.</sup>{{ number_format($pack->price , 0, ",", ".")}}<span></span></h4>
            <ul>
            <li><i class="bi bi-check"></i> <span>Quam adipiscing vitae proin</span></li>
            <li><i class="bi bi-check"></i> <span>Nec feugiat nisl pretium</span></li>
            <li><i class="bi bi-check"></i> <span>Nulla at volutpat diam uteera</span></li>
            <li class="na"><i class="bi bi-x"></i> <span>Pharetra massa massa ultricies</span></li>
            <li class="na"><i class="bi bi-x"></i> <span>Massa ultricies mi quis hendrerit</span></li>
            </ul>
            <a href="{{ route('customer/langganan.payment',$pack->id) }}" class="buy-btn">Pilih Paket</a>
        </div>
        </div><!-- End Pricing Item -->
    @endforeach
    
    </div>

    </div>

</section><!-- /Pricing Section -->




@endsection