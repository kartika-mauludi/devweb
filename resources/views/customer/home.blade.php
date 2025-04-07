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



@if($payment && $payment->status == "completed")
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
              <option value="">Show All</option>
              <option value="Edinburgh">Edinburgh</option>
              <option value="Tokyo">Tokyo</option>
              <option value="San Francisco">San Francisco</option>
            </select>
          </div>
      
            <!-- end search card -->
          <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Universitas</th>
                    <th>Website</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                
                </tr>
                <tr>
                    <td>Garrett Winters</td>
                    <td>Accountant</td>
                    <td>Tokyo</td>
                
                </tr>
                <tr>
                    <td>Ashton Cox</td>
                    <td>Junior Technical Author</td>
                    <td>San Francisco</td>
                
                </tr>
                <tr>
                    <td>Cedric Kelly</td>
                    <td>Senior Javascript Developer</td>
                    <td>Edinburgh</td>
            
                </tr>
                <tr>
                    <td>Airi Satou</td>
                    <td>Accountant</td>
                    <td>Tokyo</td>
                
                </tr>
                <tr>
                    <td>Brielle Williamson</td>
                    <td>Integration Specialist</td>
                    <td>New York</td>
            
                </tr>
                <tr>
                    <td>Herrod Chandler</td>
                    <td>Sales Assistant</td>
                    <td>San Francisco</td>
            
                </tr>
                <tr>
                    <td>Rhona Davidson</td>
                    <td>Integration Specialist</td>
                    <td>Tokyo</td>
                
                </tr>
                <tr>
                    <td>Colleen Hurst</td>
                    <td>Javascript Developer</td>
                    <td>San Francisco</td>
                
                </tr>

                <tr>
                    <td>Colleen Hurst</td>
                    <td>Javascript Developer</td>
                    <td>San Francisco</td>
                
                </tr>

                <tr>
                    <td>Colleen Hurst</td>
                    <td>Javascript Developer</td>
                    <td>San Francisco</td>
                
                </tr>

                <tr>
                    <td>Colleen Hurst</td>
                    <td>Javascript Developer</td>
                    <td>San Francisco</td>
                
                </tr>

                <tr>
                    <td>Colleen Hurst</td>
                    <td>Javascript Developer</td>
                    <td>San Francisco</td>
                
                </tr>
            
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Universitas</th>
                    <th>Website</th>
                
                </tr>
            </tfoot>
          </table>
          </div>
        </div>
      </div>

    </section><!-- /About Section -->

    @endif

  </main>

  @endsection
