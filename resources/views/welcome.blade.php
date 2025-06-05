@extends('layouts.asset')

@section('content')
  
  
  <main class="main">
    <!-- Hero Section -->
    <section id="beranda" class="hero section" style="background-image: url({{ asset('assets/img/bg/bg-blue.jpg') }});">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
            <h1 class="judul-light">ALL IN ONE PLATFORM FOR ALL RESEACH DATABASE</h1>
              <h4 class="judul-light mt-4">PERTAMA DI INDONESIA</h4>
              <h4 class="judul-light mt-4">Semua Database Riset Premium dalam Satu Langganan</h4>
              <small class="mt-2" style="color: #f5f6f8f4;">Akses 700+ database riset seperti Scopus, Web of Science, Springer, Elsevier, Sage, Taylor & Francis, Wiley, dan banyak lagi hanya dalam satu langganan</small>
            <div class="d-flex mt-4">
              <a href="#harga" class="btn-get-started">Coba Sekarang</a>
              <!-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center "><i class="bi bi-play-circle"></i><span>Watch Video</span></a> -->
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
            <img src="{{ asset('assets/img/hero-img.png') }}" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

   

    <!-- Services Section -->
    <section id="kelebihan" class="services section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Kenapa Memilih DATABASE RISET</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative text-center">
              <div class="icon"><i class="bi bi-database"></i></div>
              <h4>700+ Database Riset Premium</h4>
              <p>Dabase riset paling banyak yang dilanggan dibandingkan kampus-kampus besar di Indonesia. Dapat mendownload file PDF dari paid database</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative text-center">
              <div class="icon"><i class="bi bi-wallet2"></i></div>
              <h4>Harga Paling Terjangkau</h4>
              <p>Mulai dari 125 ribu/bulan, harga yang sangat terjangkau untuk manfaat yang luar biasa.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative text-center">
            <div class="icon"><i class="bi bi-broadcast fs-1"></i></div>
              <h4>Akses Gampang</h4>
              <p>Langsung klik melalui website, tanpa ribet.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative text-center">
              <div class="icon "><i class="bi bi-headset"></i></div>
              <h4>Fast Response</h4>
              <p>Ada masalah? Kami selalu siap membantu kapan pun kamu butuh.</p>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section><!-- /Services Section -->


    <!-- About Section -->
    <section id="tentang" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Tentang Kami</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4 justify-content-center">

          <div class="col-lg-4 content" data-aos="fade-up" data-aos-delay="100">
            <p>
           <h2><strong>APA ITU DATABASE RISET?</strong> </h1>
            </p>
            <div class="text-justify">
            Databaseriset.com adalah platform penyedia database riset premium. Anda bisa mendownload file PDF dari database berbayar. 
            Dengan databaseriset.com, Anda tidak perlu langganan satu per satu database yang Anda butuhkan. 
            Bisa Anda bayangkan database seperti Scopus, Web of Science, Springer, Elsevier, Sage, Taylor & Francis, Wiley, dan banyak lagi hanya dalam satu langganan. 
            Misi kami adalah database riset dapat diakses oleh mahasiswa, dosen, dan peneliti serta semua pihak yang membutuhkannya, khususnya di Indonesia.
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
              <img src="{{ asset('assets/img/layanan/layanan.png') }}" alt="">
          </div>

        </div>

      </div>

    </section><!-- /About Section -->

      <!-- Pricing Section -->
<section id="harga" class="pricing section light-background">
<!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
    <h2>Paket</h2>
    <p></p>
    </div><!-- End Section Title -->
    <div class="container">
    <div class="row gy-4">
    @foreach($packages as $pack)
        <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="pricing-item">
        
            <h2>{{ $pack->name }}</h2>
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
            <!-- <li class="na"><i class="bi bi-x"></i> <span>Pharetra massa massa ultricies</span></li>
            <li class="na"><i class="bi bi-x"></i> <span>Massa ultricies mi quis hendrerit</span></li> -->
            </ul>
            <a href="{{ route('payment',$pack->id) }}" class="buy-btn">Pilih Paket</a>
        </div>
        </div><!-- End Pricing Item -->
    @endforeach
    </div>
          </div>
</section><!-- /Pricing Section -->
   
    <!-- Call To Action Section -->
    <section id="layanan" class="section">
      <img src="" alt="">
      <div class="container">
        <di class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-xl-12 text-center text-xl-start">
            <h1><Center>LAYANAN</Center></h1>
          </div>
        
            <div class=" col-lg-10 col-md-12 mb-4 mb-lg-0 text-center">
             <img src="{{ asset('assets/img/layanan/scopus.png') }}" width="80" height="80" class="my-3 mx-3 rounded">
             <img src="{{ asset('assets/img/layanan/webofscience.png') }}" width="80" height="80" class="my-3 mx-3 rounded">
             <img src="{{ asset('assets/img/layanan/springer.png') }}" width="80" height="80" class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/elsevier.png') }}" width="80" height="80" class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/sage.png') }}"  class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/taylor&franch.png') }}" width="80" height="80" class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/wiley.png') }}" width="120" height="80" class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/apapsy.png') }}"  class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/ieee.png') }}" width="80" height="80" class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/sciencedirect.png') }}" width="80" height="80" class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/acm.png') }}" width="80" height="80" class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/emerald.png') }}" width="80" height="80" class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/ebscobost.png') }}" width="80" height="80" class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/jstor.png') }}" width="80" height="80" class="my-3 mx-3">
             <img src="{{ asset('assets/img/layanan/acs.png') }}" width="80" height="80" class="my-3 mx-3">
            </div>
         
        </div>
      </div>

    </section><!-- /Call To Action Section -->


    <!-- Faq 2 Section -->
    <section id="faq-2" class="faq-2 section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h1>QnA</h1>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10">

            <div class="faq-container">

              <div class="faq-item faq-active" data-aos="fade-up" data-aos-delay="200">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Bagaimana cara mengguankan databaseriset.com?</h3>
                <div class="faq-content">
                  <p>Cukup daftar, pilih paket yang Anda butuhkan, dan mulai menikmati akses +200 database riset premium. Semua dalam satu langganan!</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Apakah ini legal?</h3>
                <div class="faq-content">
                  <p>Kami menyediakan akun secara legal. Anda juga akan akses langsung ke akun database riset premium tersebut secara legal.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Apakah akun databaseriset.com bisa dibagikan?</h3>
                <div class="faq-content">
                  <p>Demi keamanan, akun Anda sebaikan tidak dibagikan. Databaseriset.com hanya mendukung login pada satu perangkat dalam satu waktu. Jika Anda login di perangkat lain, akun Anda secara otomatis akan logout dari perangkat sebelumnya. Kami memantau aktivitas login untuk memastikan keamanan data Anda tetap terjaga.</p>
                 </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Bagaimana cara melaporkan masalah?</h3>
                <div class="faq-content">
                  <p>Anda dapat melaporkan masalah dengan menghubungi tim support kami melalui Whatsapp. Kami siap membantu!</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Bagaimana saya bisa menghubungi tim support databaseriset.com?</h3>
                <div class="faq-content">
                  <p>Anda data menghubungi kami melalui Whatsapp atau bisa klik tombol Whatsapp di pojok kanan bawah.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Apakah databaseriset.com dapat digunakan di smartphone?</h3>
                <div class="faq-content">
                <p>Databaseriset.com bekerja optimal pada browser Chrome, baik pada PC ataupun pada device lainnya.</p>
              </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Apakah ada kebijakan refund di databaseriset.com?</h3>
                <div class="faq-content">
                  <p>Maaf, kami tidak menawarkan refund. Pastikan Anda membaca detail paket dengan cermat sebelum membeli.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Apa saja list database yang bisa diakses?</h3>
                <div class="faq-content">
                <p>Kami memiliki 700++ database dari 2 universitas ternama di United State. Berikut list database yang bisa digunakan.</p>
                 <div class="justify-content-center col-lg-10 mx-auto mt-3" style=" overflow: auto;  height: 400px;">
                   <table class="table table-bordered table-responsive">
                     <thead class="sticky-top">
                       <tr class="table-active">
                         <th>#</th>
                         <th>Universitas</th>
                         <th>Judul Database</th>
                       </tr>
                     </thead>
                     <tbody>
                     @foreach ($websites as $index => $web)
                     <tr>
                       <td>{{ $loop->iteration }}</td>
                         <td class="text-nowrap">
                           @if($web->university->parent == 0 || $web->university->parent === null)
                               {{ $web->university->name ?? 'Tidak Diketahui' }}
                           @elseif($web->university->parent != 0 && $web->university->parent !== null)
                               {{ \App\Models\University::where('id', $web->university->parent)->first()->name ?? 'Tidak Diketahui'}}
                           @endif
                         </td>
                         <td class="text-nowrap">{!! $web->title.' <i class="fa-solid fa-up-right-from-square"></i>' ?? 'Tidak Diketahui' !!}</td>
                     </tr>
                      @endforeach
                     </tbody>
                   </table>
                 </div>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div>

        </div>

      </div>

    </section><!-- /Faq 2 Section -->

  </main>

@endsection
