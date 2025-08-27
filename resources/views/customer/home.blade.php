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

    <!-- <a href="{{ route('customer/langganan.qris',$payment->user_id) }}" class="btn btn-primary my-2">Payment</a> -->

    <!-- Services Section -->
<section id="tabel" class="services section ">
<div class="container py-3">
  <div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12" >
    @if($sub && !($sub->subscribepackage->name === "custom" || $sub->subscribepackage->id == 99))
      @if($payment && $payment->status == "pending" && $ceksub->account_status == "non-aktif" && $sub && \Carbon\Carbon::parse($sub->created_at)->toDateString() === now()->toDateString())
        <div class="alert alert-danger alert-dismissible">
          <div class="container">
            <p> Anda Memiliki Tagihan Pembayaran Yang Belum Diselesaikan Klik Tombol Berikut Untuk Melihat Pembayaran Anda <br>
                <a href="{{ route('customer/langganan.qris',$payment->user_id) }}" class="btn btn-primary mt-2">Payment</a>
            </p>
          </div>
        </div>
       @elseif($payment && $payment->status == "pending" && $sub && $sub->account_status == "non-aktif" )
          <div class="alert alert-info alert-dismissible">
              <div class="container">
                <p> Kamu belum berlangganan, mari mulai berlangganan untuk menikmati fitur dari kami <br>
                  <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary mt-2">Mulai Berlangganan</a>
                </p>
              </div>
            </div>
        @endif
        @if($sub && now()->diffInDays(\Carbon\Carbon::parse($sub->end_date)) <=5 && $payment && $payment->status == "completed")
          <div class="alert alert-danger alert-dismissible">
            <div class="container">
              <p> Waktu Langganan Anda Akan Segera Habis, Silahkan Perpanjang Waktu Langganan Anda <br>
                <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary mt-2">Perpanjang Langganan</a>
              </p>
            </div>
          </div>
        @endif
      @elseif($sub && $sub->subscribepackage->name === "custom" && $sub->subscribepackage->id == 99 && now()->diffInDays(\Carbon\Carbon::parse($sub->end_date)) <=1 && $payment && $payment->status == "completed")
      <div class="alert alert-danger alert-dismissible">
            <div class="container">
              <p> Waktu Percobaan Anda Akan Segera Habis, Silahkan Update Langganan Anda <br>
                <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary mt-2">Perpanjang Langganan</a>
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
              @if( now()->diffInDays(\Carbon\Carbon::parse($sub->end_date)) >=0  && ($sub->subscribepackage->name === "custom" || $sub->subscribepackage->id == 99))
                <h3>Anda sedang menikmati akun percobaan</h3>
                <h5 class="my-3"><p>Akun Percobaan Berakhir pada {{ \Carbon\Carbon::parse($sub->end_date)->format("d F Y") }}</p>
                </h5>
                <p> <a href="{{ route('customer/langganan.index') }}" class="btn btn-primary">langganan Sekarang</a> </p>
              @elseif(\Carbon\Carbon::parse($sub->end_date) < now())
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
              <h2 class="mb-3">Rp {{  number_format( $komisi  , 0, ",", ".") }} </h2>
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
                @endforeach
              @endif
              <h3>Update Agent</h3>
              <button id="updateAgent" class="btn btn-warning text-white">
                <i class="bi bi-arrow-clockwise"></i> Update Agent
              </button>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12" >
           <div class="service-item position-relative" style="border:1px">
            <h3> Video </h3>
              @if($videos)
                @foreach ($videos as $video )
                    <h5 class="py-1 px-2" data-bs-toggle="modal" data-bs-target="#globalModal" data-id="{{ $video->id }}"  data-url="{{ $video->link }}"  data-title="{{ $video->name }}" style="cursor: pointer;"><i class="bi bi-play-fill"></i> {{ $video->name }}</h5>
                  </h5>
                @endforeach
              @endif
            </div>
          </div>
          @if(optional($bonus)->bonus)
          <div class="col-xl-12 col-lg-12 col-md-12" >
           <div class="service-item position-relative" style="border:1px">
            <h3> Bonus </h3>
              <table class="table">
                <thead>
                  <tr>
                    <th><center>#</center></th>
                    <th><center>Username</center></th>
                    <th><center>Password</center></th>
                    <th><center>File</center></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><center>{{ $bonus->bonus->name }}</center></td>
                    <td><center>{{ $bonus->bonus->username }}</center></td>
                    <td><center>{{ $bonus->bonus->password }}</center></td>
                    <td>  <a href="{{ asset('storage') }}/{{ $bonus->bonus->file_location }}" target="_blank" download="">
                      <h6 class="pt-3 px-2"><center><i class="bi bi-download"></i> Unduh {{ $bonus->bonus->name }}</center></h6>
                    </a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          @elseif($bonus_global) 
          <div class="col-xl-12 col-lg-12 col-md-12" >
           <div class="service-item position-relative" style="border:1px">
            <h3> Bonus </h3>
              <table class="table">
                <thead>
                  <tr>
                    <th><center>#</center></th>
                    <th><center>Username</center></th>
                    <th><center>Password</center></th>
                    <th><center>File</center></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><center>{{ $bonus_global->name }} </center></td>
                    <td><center>{{ $bonus_global->username }}</center></td>
                    <td><center>{{ $bonus_global->password }}</center></td>
                    <td>  <a href="{{ asset('storage') }}/{{ $bonus_global->file_location }}" target="_blank" download="">
                      <h6 class="pt-3 px-2"><center><i class="bi bi-download"></i> Unduh {{ $bonus_global->name }}</center></h6>
                    </a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          @endif
        </div>
      </div>
    </section>
    @if($sub && \Carbon\Carbon::parse($sub->end_date) >= now() && $sub->account_status == "aktif" ) 
    <section id="database" class="about section">
      <div class="container section-title" data-aos="fade-up">
        <h2 class="my-auto">Databases</h2>
        <a href="https://unairsatu.unair.ac.id/" style="display: none;">Akses</a>
      </div>
      <div class="container section-title" data-aos="fade-up" id="uc_login_database">
        <a href="#database" class="btn btn-primary" id="db_login" style="display: none;"> Login Database</a>
        <p class="text-danger fs-5 mt-3 fw-bold" id="pesan">Silahkan menginstall Agent (khusus windows) dan Ekstensi terlebih dahulu!</p>
      </div>
      <div class="container section-title" data-aos="fade-up" id="uc_logout_database">
        <a href="#database" class="btn btn-danger" id="db_logout" style="display: none;"> Logout Database</a>
      </div>

      <div class="d-flex justify-content-center p-2">
        <div>
          @php
          $akunIds = $user->akun_id;
          $universityNames = App\Models\UniversityAccount::with('university')->whereIn('id', $akunIds)->get()->pluck('university.name');
          $univAcc = App\Models\UniversityAccount::with('university')->whereIn('id', $akunIds)->first();
          $univNameLower = $universityNames->map(fn($name) => strtolower($name));
          @endphp
          <p id="jalankan" style="display: none;">Jalankan otomatisasi:</p>
          @if (Str::contains($univNameLower, 'cincinnati'))
            <a href="#database" class="btn btn-primary" id="uc_login" style="display: none;">CINCINNATI</a>
          @endif
          @if (Str::contains($univNameLower, 'arizona'))
            <a href="#database" class="btn btn-primary" id="con_ASU_1" style="display: none;">ARIZONA</a>
          @endif
          @if (Str::contains($univNameLower, 'auraria'))
            <a href="#database" class="btn btn-primary" id="auraria" style="display: none;">AURARIA</a>
          @endif
          @if (Str::contains($univNameLower, 'oakland'))
            <a href="#database" class="btn btn-primary" id="oakland" style="display: none;">OAKLAND</a>
          @endif
          @if (Str::contains($univNameLower, 'airlangga'))
            <a href="#database" class="btn btn-primary" id="con_UNAIR_1" style="display: none;">UNAIR_1</a>
          @endif
        </div>
      </div>

      <div class="d-flex justify-content-center p-2">
        <div>
          <p id="hentikan" style="display: none;">Berhentikan otomatisasi:</p>
          <a href="#database" class="btn btn-danger" id="dis_ASU_1" style="display: none;">ARIZONA_1</a>
          <a href="#database" class="btn btn-danger" id="dis_UNAIR_1" style="display: none;">UNAIR_1</a>
          <a href="#database" class="btn btn-danger" id="dis_UNAIR_2" style="display: none;">UNAIR_2</a>
          <a href="#database" class="btn btn-danger" id="dis_UNAIR_3" style="display: none;">UNAIR_3</a>
          <a href="#database" class="btn btn-danger" id="dis_UNAIR_4" style="display: none;">UNAIR_4</a>
        </div>
      </div>

      {{-- <div id="status"><center>Status: Menunggu perintah...</center></dopeiv> --}}

      <div class="container" id="listdatabase" style="display: none;">
        <div class="row justify-content-center">
          <div class="col-lg-12 content">
          <div class="container mt-4">
          <div class="category-filter">
            <select id="categoryFilter" class="form-control">
              <option value="show" hidden selected class="bg-muted text-secondary"><i class="fas fa-filter"></i> Filter by University</option>
              <option value="">Show All</option>
              {{-- @foreach ( $univs as $univ )
                   <option value="{{ $univ->name }}">{{ $univ->name }}</option>
              @endforeach --}}
              @foreach ($universityNames as $una)
                <option value="{{ $una }}">{{ $una }}</option>
              @endforeach
            </select>
          </div>
          <div class="table-responsive">
          <table id="filterTable" class="table display w-100 ">
            <thead>
                <tr>
                    <th>Nama Universitas</th>
                    <th>Judul Database</th>
                    <!-- <th>URL Website</th> -->
                </tr>
            </thead>
            @php
                $univId = App\Models\UniversityAccount::with('university')->whereIn('id', $akunIds)->get()->pluck('university.id');
                $websitesUniv = App\Models\UniversityWebsite::with('university')->whereIn('university_id', $univId)->get();
            @endphp
            <tbody>
              @foreach ( $websitesUniv as $wu)
                <tr>
                  <td class="text-nowrap">
                    @if($wu->university->parent == 0 || $wu->university->parent === null)
                        {{ $wu->university->name ?? 'Tidak Diketahui' }}
                    @elseif($wu->university->parent != 0 && $wu->university->parent !== null)
                        {{ \App\Models\University::where('id', $wu->university->parent)->first()->name ?? 'Tidak Diketahui'}}
                    @endif
                  </td>
                  <td class="text-nowrap"><a href="{{ $wu->url }}" target="_blank">{!! $wu->title.' <i class="fa-solid fa-up-right-from-square"></i>' ?? 'Tidak Diketahui' !!}</a></td>
                </tr>
              @endforeach
                {{-- @foreach ($websites as $index => $web)
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
                @endforeach --}}
            </tbody>
          </table>
          </div>
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
      const tombol1 = $('#con_ASU_1');
      const tombol2 = $('#con_UNAIR_1');
      const tombol3 = $('#con_UNAIR_2');
      const tombol4 = $('#con_UNAIR_3');
      const tombol5 = $('#con_UNAIR_4');

      // const socket = new WebSocket('ws://localhost:64135');

      // socket.onerror = function(error) {
      //     const btn = document.getElementById('db_login');
      //     if (btn) {
      //       btn.style.display = 'none';
      //       const pesan = document.getElementById('pesan');
      //       pesan.style.display = 'block';
      //       alert('Silahkan install agent dan ekstensi terlebih dahulu untuk mengakses database!');
      //     }
      // };

      function getOS() {
        const userAgent = navigator.userAgent || navigator.vendor || window.opera;
        const platform = navigator.platform.toLowerCase();

        if (platform.includes('win')) return 'Windows';
        if (platform.includes('mac')) return 'macOS';
        if (platform.includes('linux')) return 'Linux';
        if (/android/i.test(userAgent)) return 'Android';
        if (/iphone|ipad|ipod/i.test(userAgent)) return 'iOS';

        return 'Unknown';
      }

console.log("Operating System:", getOS());

if (getOS() === 'Windows') {

  window.addEventListener("message", function(event) {
    if (event.source !== window) return;

    if (event.data && event.data.from === "databaseriset" && event.data.installed === true) {
      console.log("Ekstensi terpasang!");

      const btn = document.getElementById('db_login');
      if (btn) {
        btn.style.display = 'inline';
        const pesan = document.getElementById('pesan');
        pesan.style.display = 'none';
      }

      // Lakukan sesuatu, misalnya: ubah UI, set cookie, dll
    }
  });

  const socket = new WebSocket('ws://localhost:64135');

    socket.onerror = function(error) {
        const btn = document.getElementById('db_login');
        if (btn) {
          btn.style.display = 'none';
          const pesan = document.getElementById('pesan');
          pesan.style.display = 'block';
          alert('Untuk pengguna Windows, silahkan install agent dan ekstensi terlebih dahulu untuk mengakses database!');
        }
    };
}

if (getOS() === 'macOS') {
  window.addEventListener("message", function(event) {
    if (event.source !== window) return;

    if (event.data && event.data.from === "databaseriset" && event.data.installed === true) {
      console.log("Ekstensi terpasang!");

      const btn = document.getElementById('db_login');
      if (btn) {
        btn.style.display = 'inline';
        const pesan = document.getElementById('pesan');
        pesan.style.display = 'none';
      }

      // Lakukan sesuatu, misalnya: ubah UI, set cookie, dll
    }
  });
}

      // Periksa state saat halaman dimuat
      function periksaStateSaatLoad() {
        const stateTersimpan = localStorage.getItem('tombolAktif');

        // Jika state 'tombol2' tersimpan, sesuaikan tampilan
        if (stateTersimpan === 'tombol1') {
            $("#con_ASU_1").hide();
            $("#dis_ASU_1").show();
        } else if (stateTersimpan === 'tombol2') {
            $("#con_UNAIR_1").hide();
            $("#dis_UNAIR_1").show();
            $("#con_UNAIR_2").addClass("disabled");
            $("#con_UNAIR_3").addClass("disabled");
            $("#con_UNAIR_4").addClass("disabled");
        } else if (stateTersimpan === 'tombol3') {
            $("#con_UNAIR_2").hide();
            $("#dis_UNAIR_2").show();
            $("#con_UNAIR_1").addClass("disabled");
            $("#con_UNAIR_3").addClass("disabled");
            $("#con_UNAIR_4").addClass("disabled");
        } else if (stateTersimpan === 'tombol4') {
            $("#con_UNAIR_3").hide();
            $("#dis_UNAIR_3").show();
            $("#con_UNAIR_1").addClass("disabled");
            $("#con_UNAIR_2").addClass("disabled");
            $("#con_UNAIR_4").addClass("disabled");
        } else if (stateTersimpan === 'tombol5') {
            $("#con_UNAIR_4").hide();
            $("#dis_UNAIR_4").show();
            $("#con_UNAIR_1").addClass("disabled");
            $("#con_UNAIR_2").addClass("disabled");
            $("#con_UNAIR_3").addClass("disabled");
        } else {
            // Jika state 'tombol1' tidak tersimpan, sesuaikan tampilan
            $("#con_ASU_1").hide();
            $("#dis_ASU_1").hide();
            $("#con_UNAIR_1").removeClass("disabled");
            $("#con_UNAIR_2").removeClass("disabled");
            $("#con_UNAIR_3").removeClass("disabled");
            $("#con_UNAIR_4").removeClass("disabled");
        }
    }

    periksaStateSaatLoad();

      $("#filterTable").dataTable({
        "searching": true,
        "pageLength": 50
      });
      var table = $('#filterTable').DataTable();
      $("#filterTable_filter.dataTables_filter").append($("#categoryFilter"));
      var categoryIndex = 0;
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

      $("#updateAgent").click(function(e){
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "SYNC", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "", //"openvpn atau anyconnect"
                univ: "",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            // localStorage.setItem('tombolAktif', 'tombol1');

            // const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

      let socketOpen = function() {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');
        
        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "REGISTRY_OFF", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#db_login").addClass("d-none");
            $("#db_logout").show();
            $("#listdatabase").show();
            $("#uc_login").show();
            $("#con_ASU_1").show();
            $("#con_UNAIR_1").show();
            $("#con_UNAIR_2").show();
            $("#con_UNAIR_3").show();
            $("#con_UNAIR_4").show();
            $("#jalankan").show();
            $("#hentikan").show();
            $("#auraria").show();
            $("#oakland").show();
          };

          let retError = "";

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
              retError = error;
              return retError;
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
              retError = error;
              return retError;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        };

        // $("#db_login").click(function(e){
          // alert("Pastikan ekstensi telah terinstall jika tombol tidak melakukan aksi apapun.");
        //   socketOpen();
        //   $("#db_login").addClass("d-none");
        //   $("#db_logout").show();
        //   $("#listdatabase").show();
        //   $("#uc_login").show();
        //   $("#con_ASU_1").show();
        //   $("#con_UNAIR_1").show();
        //   $("#con_UNAIR_2").show();
        //   $("#con_UNAIR_3").show();
        //   $("#con_UNAIR_4").show();
        //   $("#jalankan").show();
        //   $("#hentikan").show();
        //   $("#auraria").show();
        //   $("#oakland").show();
        // });

        // REGISTRY_ON
        // $("#db_logout").click(function(e){
          // $("#db_login").removeClass("d-none");
          // $("#db_login").show();
          // $("#db_logout").hide();
          // $("#listdatabase").hide();
          // $("#uc_login").hide();
          // $("#con_ASU_1").hide();
          // $("#con_UNAIR_1").hide();
          // $("#con_UNAIR_2").hide();
          // $("#con_UNAIR_3").hide();
          // $("#con_UNAIR_4").hide();
          // $("#dis_ASU_1").hide();
          // $("#dis_UNAIR_1").hide();
          // $("#dis_UNAIR_2").hide();
          // $("#dis_UNAIR_3").hide();
          // $("#dis_UNAIR_4").hide();
          // $("#jalankan").hide();
          // $("#hentikan").hide();
          // $("#auraria").hide();
          // $("#oakland").hide();
        //   const statusDiv = $("#status");
        // const socket = new WebSocket('ws://localhost:64135');

        // socket.onopen = function() {
        //     statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
        //     // console.log('Koneksi berhasil dibuka.');

        //     // Siapkan data perintah dalam format JSON
        //     const perintah = {
        //         action: "REGISTRY_ON", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
        //     };

        //     // Kirim data perintah sebagai teks JSON
        //     socket.send(JSON.stringify(perintah));

        //     $("#db_login").removeClass("d-none");
        //     $("#db_login").show();
        //     $("#db_logout").hide();
        //     $("#listdatabase").hide();
        //     $("#uc_login").hide();
        //     $("#con_ASU_1").hide();
        //     $("#con_UNAIR_1").hide();
        //     $("#con_UNAIR_2").hide();
        //     $("#con_UNAIR_3").hide();
        //     $("#con_UNAIR_4").hide();
        //     $("#dis_ASU_1").hide();
        //     $("#dis_UNAIR_1").hide();
        //     $("#dis_UNAIR_2").hide();
        //     $("#dis_UNAIR_3").hide();
        //     $("#dis_UNAIR_4").hide();
        //     $("#jalankan").hide();
        //     $("#hentikan").hide();
        //     $("#auraria").hide();
        //     $("#oakland").hide();
        //   };

        //   socket.onerror = function(error) {
        //       statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
        //       console.error('WebSocket Error: ', error);
        //   };

        //   socket.onmessage = function(event) {
        //       console.log('Pesan dari server:', event.data);
        //       statusDiv.textContent = 'Status: ' + event.data;
        //   };

        //   socket.onclose = function() {
        //       console.log('Koneksi WebSocket ditutup.');
        //   };
        // });

        // Cincinnati Login
      $("#uc_login").click(function(e){
        // socketOpen();

        const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

        // window.open("https://catalyst.uc.edu", '_blank');
        window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
      });

        // REGISTRY_CONNECT: ASU_1
        $("#con_ASU_1").click(function(e){
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "CONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "anyconnect", //"openvpn atau anyconnect"
                univ: "ASU_1",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_ASU_1").hide();
            $("#dis_ASU_1").show();

            localStorage.setItem('tombolAktif', 'tombol1');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

        // REGISTRY_DISCONNECT: ASU_1
        $("#dis_ASU_1").click(function(e){
          const statusDiv = $("#status");
          const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "DISCONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "anyconnect", //"openvpn atau anyconnect"
                univ: "ASU_1",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_ASU_1").show();
            $("#dis_ASU_1").hide();

            localStorage.removeItem('tombolAktif', 'tombol1');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

        // REGISTRY_CONNECT: UNAIR_1
        $("#con_UNAIR_1").click(function(e){
          const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "CONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_1",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_1").hide();
            $("#dis_UNAIR_1").show();
            $("#con_UNAIR_2").addClass("disabled");
            $("#con_UNAIR_3").addClass("disabled");
            $("#con_UNAIR_4").addClass("disabled");

            localStorage.setItem('tombolAktif', 'tombol2');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

        // REGISTRY_DISCONNECT: UNAIR_1
        $("#dis_UNAIR_1").click(function(e){
          const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "DISCONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_1",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_1").show();
            $("#dis_UNAIR_1").hide();
            $("#con_UNAIR_2").removeClass("disabled");
            $("#con_UNAIR_3").removeClass("disabled");
            $("#con_UNAIR_4").removeClass("disabled");

            localStorage.removeItem('tombolAktif', 'tombol2');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

        // REGISTRY_CONNECT: UNAIR_2
        $("#con_UNAIR_2").click(function(e){
          const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "CONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_2",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_2").hide();
            $("#dis_UNAIR_2").show();
            $("#con_UNAIR_1").addClass("disabled");
            $("#con_UNAIR_3").addClass("disabled");
            $("#con_UNAIR_4").addClass("disabled");

            localStorage.setItem('tombolAktif', 'tombol3');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

        // REGISTRY_DISCONNECT: UNAIR_2
        $("#dis_UNAIR_2").click(function(e){
          const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "DISCONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_2",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_2").show();
            $("#dis_UNAIR_2").hide();
            $("#con_UNAIR_1").removeClass("disabled");
            $("#con_UNAIR_3").removeClass("disabled");
            $("#con_UNAIR_4").removeClass("disabled");

            localStorage.removeItem('tombolAktif', 'tombol3');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

       const globalModal = document.getElementById('globalModal');
        globalModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const videoUrl = button.getAttribute('data-url');
        const videoTitle = button.getAttribute('data-title');
        
        const modalTitle = globalModal.querySelector('.modal-title');
        const iframe = globalModal.querySelector('#globalIframe');

        modalTitle.textContent = videoTitle;
        iframe.src = videoUrl;
      });

      // REGISTRY_CONNECT: UNAIR_3
        $("#con_UNAIR_3").click(function(e){
          const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "CONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_3",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_3").hide();
            $("#dis_UNAIR_3").show();
            $("#con_UNAIR_1").addClass("disabled");
            $("#con_UNAIR_2").addClass("disabled");
            $("#con_UNAIR_4").addClass("disabled");

            localStorage.setItem('tombolAktif', 'tombol4');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

        // REGISTRY_DISCONNECT: UNAIR_3
        $("#dis_UNAIR_3").click(function(e){
          const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "DISCONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_3",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_3").show();
            $("#dis_UNAIR_3").hide();
            $("#con_UNAIR_1").removeClass("disabled");
            $("#con_UNAIR_2").removeClass("disabled");
            $("#con_UNAIR_4").removeClass("disabled");

            localStorage.removeItem('tombolAktif', 'tombol4');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

        // REGISTRY_CONNECT: UNAIR_4
        $("#con_UNAIR_4").click(function(e){
          const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "CONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_4",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_4").hide();
            $("#dis_UNAIR_4").show();
            $("#con_UNAIR_1").addClass("disabled");
            $("#con_UNAIR_2").addClass("disabled");
            $("#con_UNAIR_3").addClass("disabled");

            localStorage.setItem('tombolAktif', 'tombol5');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

        // REGISTRY_DISCONNECT: UNAIR_4
        $("#dis_UNAIR_4").click(function(e){
          const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "DISCONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_4",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_4").show();
            $("#dis_UNAIR_4").hide();
            $("#con_UNAIR_1").removeClass("disabled");
            $("#con_UNAIR_2").removeClass("disabled");
            $("#con_UNAIR_3").removeClass("disabled");

            localStorage.removeItem('tombolAktif', 'tombol5');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
          };

          socket.onerror = function(error) {
              statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
              console.error('WebSocket Error: ', error);
          };

          socket.onmessage = function(event) {
              console.log('Pesan dari server:', event.data);
              statusDiv.textContent = 'Status: ' + event.data;
          };

          socket.onclose = function() {
              console.log('Koneksi WebSocket ditutup.');
          };
        });

      // Kosongkan iframe saat modal ditutup (agar video stop otomatis)
      globalModal.addEventListener('hidden.bs.modal', function () {
        const iframe = globalModal.querySelector('#globalIframe');
        iframe.src = '';
      });


  </script>
  @endpush
