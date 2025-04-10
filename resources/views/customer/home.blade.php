@extends('customer.asset')

@section('content')
  
  
  <main class="main">
    <!-- Hero Section -->
    <section id="beranda" class="hero section" style="background-image: url({{ asset('assets/img/bg/bg-blue.jpg') }});">
        <div class="container">
            <div class="" data-aos="zoom-out">
                <h1 class="judul-light text-center">DASHBOARD</h1>
            </div>
        </div>
    </section><!-- /Hero Section -->
    @if (session('message'))
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('message') }}
            </div>
        @endsession

        @if (session('error_payment'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('error_payment') }}
            </div>
        @endsession
    <!-- Services Section -->
    <section id="tabel" class="services section light-background">
    @if($payment && $payment->status == "pending" && !empty($payment->redirect_link))
      <div class="alert alert-danger alert-dismissible">
        <div class="container">
          Anda Memiliki Tagihan Pembayaran Yang Belum Diselesaikan Klik Tombol Berikut Untuk Melihat Pembayaran Anda <p>
            <a href="{{ route('customer/langganan.qris',$payment->user_id) }}" class="btn btn-primary my-2">Payment</a>
          </p>
          </div>
      </div>
    @elseif($payment && $payment->status == "pending" && empty($payment->redirect_link))
    <div class="alert alert-info alert-dismissible">
        <div class="container">
         Ada masalah ketika registrasi anda sehingga pembayaran anda tidak terdeteksi, silahkan hubungi admin atau klik menu langgalan untuk berlangganan <p>
            <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary my-2">Mulai Berlangganan</a>
          </p>
          </div>
    </div>
    @elseif($payment && $payment->status == "failed")
    <div class="alert alert-info alert-dismissible">
        <div class="container">
          Kamu belum berlangganan, mari mulai berlangganan untuk menikmati fitur dari kami <p>
            <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary my-2">Mulai Berlangganan</a>
          </p>
          </div>
      </div>
    @endif
    @if($sub && now()->diffInDays(\Carbon\Carbon::parse($sub->end_date)) <=3 && $payment->status == "completed")
    <div class="alert alert-dangery alert-dismissible">
      <div class="container">
              Waktu Langganan Anda Akan Segera Habis, Silahkan Perpanjang Waktu Langganan Anda <p>
          <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary my-2">Perpanjang Langganan</a>
        </p>
        </div>
    </div>
    @endif
      <!-- Section Title -->
      <div class="container">
        <div class="row justify-content-center">

        @if ($sub)
          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="service-item position-relative">
              <!-- {{ now()->diffInDays(\Carbon\Carbon::parse($sub->end_date)) }} -->
            @if(\Carbon\Carbon::parse($sub->end_date) < now())
            <h3 style="text:red">Anda Belum Berlangganan</h3>
              <h5 class="my-3">Pilih Paket Untuk Menikmati Layanan Kami</h5>
              <p> <a href="{{ route('customer/langganan.index') }}" class="btn btn-primary">langganan Sekarang</a> </p>
            @elseif(\Carbon\Carbon::parse($sub->end_date) >= now() && $payment->status == "completed" )
              <h3>Data Langganan Anda</h3>
              <h2> {{ $sub->subscribepackage->name }}</h2>
              <p>Berakhir pada {{ \Carbon\Carbon::parse($sub->end_date)->format("d F Y") }}</p>
              @endif
            </div>
          </div><!-- End Service Item -->
        @endif

          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="service-item position-relative">
              <h3>Komisi Anda</h3>
              <h2 class="mb-3">Rp {{ $komisi }}</h2>
              <a href="{{ route('customer/affiliasi.index') }}" class="btn btn-primary rounded btn-sm text-white">Mulai Datapkan Komisi</a>
            </div>
          </div><!-- End Service Item -->
        </div>

      </div>

    </section><!-- /Services Section -->




    <!-- About Section -->
    <section id="database" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2 class="my-auto">Databases</h2>
      </div><!-- End Section Title -->

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10 content">
          <div class="container mt-4">
          <div class="category-filter">
            <select id="categoryFilter" class="form-control">
              <option value="show" hidden selected class="bg-muted text-secondary"><i class="fas fa-filter"></i> Filter by University</option>
              <option value="">Show All</option>
              @foreach ( $univs as $univ )
               <option value="{{ $univ->name }}">{{ $univ->name }}</option>
              @endforeach
            </select>
          </div>
      
            <!-- end search card -->
          <table id="filterTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Website</th>
                    <th>Universitas</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($websites as $web )
              <tr>
                    <td>{{ $loop->iteration }}</td>
                    @foreach ( $akuns as $akun )
                        @foreach ( $web->universities as $univ )
                        @if($akun->university->id == $univ->id)
                          <td><a href="{{ url('akun/') }}?username={{ $akun->username }}&pass={{ $akun->password }}">{{ $web->name }}</a></td>
                        @endif
                        @endforeach
                      
                       @endforeach
                    @foreach ( $web->universities as $univ )
                       <td>{{ $univ->name }}</td>
                    @endforeach
                   
                </tr>
              @endforeach
                
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Website</th>
                    <th>Universitas</th>
                
                </tr>
            </tfoot>
          </table>
          </div>
        </div>
      </div>

    </section><!-- /About Section -->


  </main>

  @endsection
