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
          <p> Anda Memiliki Tagihan Pembayaran Yang Belum Diselesaikan Klik Tombol Berikut Untuk Melihat Pembayaran Anda
            <a href="{{ route('customer/langganan.qris',$payment->user_id) }}" class="btn btn-primary my-2">Payment</a>
          </p>
        </div>
      </div>
    @elseif($payment && $payment->status == "pending" && empty($payment->redirect_link))
      <div class="alert alert-info alert-dismissible">
          <div class="container">
            <p> Ada masalah ketika registrasi anda sehingga pembayaran anda tidak terdeteksi, silahkan hubungi admin atau klik menu langgalan untuk berlangganan
              <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary my-2">Mulai Berlangganan</a>
            </p>
          </div>
      </div>
    @elseif($payment && $payment->status == "failed")
      <div class="alert alert-info alert-dismissible">
          <div class="container">
            <p> Kamu belum berlangganan, mari mulai berlangganan untuk menikmati fitur dari kami
              <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary my-2">Mulai Berlangganan</a>
            </p>
          </div>
        </div>
    @endif
    @if($sub && now()->diffInDays(\Carbon\Carbon::parse($sub->end_date)) <=3 && $payment->status == "completed")
      <div class="alert alert-dangery alert-dismissible">
        <div class="container">
          <p> Waktu Langganan Anda Akan Segera Habis, Silahkan Perpanjang Waktu Langganan Anda
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
            <table id="filterTable" class="display w-100">
            <thead>
                <tr>
                    <th>Nama Universitas</th>
                    <th>Judul</th>
                    <th>URL Website</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($websites as $index => $web)
                    <tr>
                        <td class="text-nowrap">{{ $web->university->name ?? 'Tidak Diketahui' }}</td>
                        <td class="text-nowrap">{{ $web->title ?? 'Tidak Diketahui' }}</td>
                        <td><a href="#" data-url="{{ $web->url }}" data-bs-toggle="modal" data-bs-target="#loginModal">{{ $web->url }}</a></td>
                    </tr>
                @endforeach
            </tbody>
          </table>

          </div>
        </div>
      </div>

    </section><!-- /About Section -->

    <div id="loginModal" class="modal fade" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Login</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <iframe id="loginFrame" is="x-frame-bypass" style="height: 80vh;" src=""></iframe>
        </div>
      </div>
    </div>


  </main>

  @endsection

  @push('script')
  <script>
    $("document").ready(function () {
      $("#filterTable").dataTable({
        "searching": true
      });
      var table = $('#filterTable').DataTable();
      $("#filterTable_filter.dataTables_filter").append($("#categoryFilter"));
      var categoryIndex = 0;
      $("#filterTable th").each(function (i) {
        if ($($(this)).html() == "Universitas") {
          categoryIndex = i; return false;
        }
      });
      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem = $('#categoryFilter').val()
          var category = data[categoryIndex];
          if (selectedItem === "all" || selectedItem === "show" || category.includes(selectedItem)) {
            return true;
          } 
          return false;
        }
      );
      $("#categoryFilter").change(function (e) {
        table.draw();
      });

      table.draw();
    });

    $('#loginModal').on('show.bs.modal', function (e) {
      const button = $(e.relatedTarget);
      const url = button.data('url');
      $('#loginFrame').attr('src', url);
    });

    $('#loginFrame').on('load', function () {
        const iframe = this;
        try {
            const currentUrl = iframe.contentWindow.location.href;
            console.log('Iframe loaded. Current URL:', currentUrl);

            $("#username").val('wjune12');
            $("#password").val('Pejuang45!@!@');
            console.log('cok');
            
        } catch (e) {
            console.warn('Tidak bisa mengakses isi iframe karena perbedaan domain.');
        }
    });




    $('#loginModal').on('hidden.bs.modal', function () {
      $('#loginFrame').attr('src', ''); // kosongkan saat modal ditutup
    });


  </script>
  @endpush
