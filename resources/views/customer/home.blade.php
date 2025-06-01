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
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
        {{ session('message') }}
      </div>
    @endsession

    @if (session('error_payment'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">×</button>
        {{ session('error_payment') }}
      </div>
    @endsession

    <!-- Services Section -->
<section id="tabel" class="services section ">
<div class="container py-3">
  <div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12" >
      @if($payment && $payment->status == "pending" && $ceksub->account_status == "non-aktif" && \Carbon\Carbon::parse($sub->created_at)->toDateString() === now()->toDateString())
        <div class="alert alert-danger alert-dismissible">
          <div class="container">
            <p> Anda Memiliki Tagihan Pembayaran Yang Belum Diselesaikan Klik Tombol Berikut Untuk Melihat Pembayaran Anda
              <a href="{{ route('customer/langganan.qris',$payment->user_id) }}" class="btn btn-primary my-2">Payment</a>
            </p>
          </div>
        </div>
       @elseif($payment && $payment->status == "failed" && $sub->account_status == "non-aktif" )
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
      </div>
    </div>
  </div>
      <!-- Section Title -->
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="service-item position-relative">
            @if ($sub)
              <!-- {{ now()->diffInDays(\Carbon\Carbon::parse($sub->end_date)) }} -->
              @if(\Carbon\Carbon::parse($sub->end_date) < now())
                <h3 style="text:red">Anda Belum Berlangganan</h3>
                <h5 class="my-3">Pilih Paket Untuk Menikmati Layanan Kami</h5>
                <p> <a href="{{ route('customer/langganan.index') }}" class="btn btn-primary">langganan Sekarang</a> </p>
              @elseif(\Carbon\Carbon::parse($sub->end_date) >= now() && $payment->status == "completed" )
                <h3>Data Langganan Anda</h3>
                <h2> {{ $sub->subscribepackage->name }}</h2>
                <p>Berakhir pada {{ \Carbon\Carbon::parse($sub->end_date)->format("d F Y") }}</p>
              @elseif(\Carbon\Carbon::parse($sub->end_date) >= now() && $sub->account_status == "aktif" )
                <h3>Data Langganan Anda</h3>
                <h2> {{ $sub->subscribepackage->name }}</h2>
                <p>Berakhir pada {{ \Carbon\Carbon::parse($sub->end_date)->format("d F Y") }}</p>
              @elseif(\Carbon\Carbon::parse($sub->end_date) >= now() && $sub->account_status == "non-aktif" )
                <h3 style="text:red">Anda Belum Berlangganan</h3>
                <h5 class="my-3">Pilih Paket Untuk Menikmati Layanan Kami</h5>
                <p> <a href="{{ route('customer/langganan.index') }}" class="btn btn-primary">langganan Sekarang</a> </p>
              @endif
            @else
              <h3 style="text:red">Anda Belum Berlangganan</h3>
              <h5 class="my-3">Pilih Paket Untuk Menikmati Layanan Kami</h5>
              <p> <a href="{{ route('customer/langganan.index') }}" class="btn btn-primary">langganan Sekarang</a> </p>
            @endif
            </div>
          </div><!-- End Service Item -->
          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="service-item position-relative">
              <h3>Komisi Anda</h3>
              <h2 class="mb-3">Rp {{ $komisi }}</h2>
              <a href="{{ route('customer/affiliasi.index') }}" class="btn btn-primary rounded btn-sm text-white">Mulai Dapatkan Komisi</a>
            </div>
          </div><!-- End Service Item -->
        </div>
      </div>
     <div class="container py-3">
       <div class="row justify-content-center">
         <div class="col-xl-12 col-lg-12 col-md-12" >
            <div class="service-item position-relative" style="border:1px">
            <h3> Ekstensi </h3>
              @if($files)
                @foreach ($files as $file )
                  @if($file->type === "extension")
                    <a href="{{ asset('storage') }}/{{ $file->file_location }}" target="_blank" download="">
                      <h5 class="pt-3 px-2"><i class="bi bi-download"></i> Unduh {{ $file->name }}</h5>
                    </a>
                  @endif
                  @if($file->type === "video")
                    <h5 class="py-1 px-2" data-bs-toggle="modal" data-bs-target="#globalModal" data-id="{{ $file->id }}"  data-url="{{ $file->link }}"  data-title="{{ $file->name }}"><i class="bi bi-play-fill"></i> {{ $file->name }}</h5>
                  </h5>
                    @endif
                @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
    @if(\Carbon\Carbon::parse($sub->end_date) >= now() && $sub->account_status == "aktif" ) 
    <section id="database" class="about section">
      <div class="container section-title" data-aos="fade-up">
        <h2 class="my-auto">Databases</h2>
      </div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 content">
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
          <table id="filterTable" class="display w-100">
            <thead>
                <tr>
                    <th>Nama Universitas</th>
                    <th>Judul</th>
                    <!-- <th>URL Website</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($websites as $index => $web)
                    <tr>
                        <td class="text-nowrap">
                          @if($web->university->parent == 0 || $web->university->parent === null)
                              {{ $web->university->name ?? 'Tidak Diketahui' }}
                          @elseif($web->university->parent != 0 && $web->university->parent !== null)
                              {{ \App\Models\University::where('id', $web->university->parent)->first()->name ?? 'Tidak Diketahui'}}
                          @endif
                        </td>
                        <td class="text-nowrap"><a href="{{ $web->url }}" target="_blank">{!! $web->title.' <i class="fa-solid fa-up-right-from-square"></i>' ?? 'Tidak Diketahui' !!}</a></td>
                    </tr>
                @endforeach
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </section>
    @endif
  </main>


  <!-- Modal VIdeo -->
  <div class="modal fade" id="globalModal" tabindex="-1" aria-labelledby="globalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="globalModalLabel">Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <iframe id="globalIframe" src="" width="100%" height="600px" style="border: none;"></iframe>
      </div>
    </div>
  </div>
</div>




  @endsection
  @push('script')
  <script>
    $("document").ready(function () {
      $("#filterTable").dataTable({
        "searching": true,
        "pageLength": 50
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
  </script>
  @if (session('extension_token'))
  <script>
      window.addEventListener('DOMContentLoaded', () => {
          window.postMessage({
              type: 'SEND_TOKEN_TO_EXTENSION',
              token: "{{ session('extension_token') }}"
          }, "*");
      });
  </script>
   @endif

   <script>
    document.getElementById('globalModal').addEventListener('show.bs.modal', function (event) {
    const trigger = event.relatedTarget;
    const url = trigger.getAttribute('data-url');
    const title = trigger.getAttribute('data-title');

    document.getElementById('globalIframe').src = url;
    document.getElementById('globalModalLabel').textContent = title;
  });

   </script>
  @endpush
