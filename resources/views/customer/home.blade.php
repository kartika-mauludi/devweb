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
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                @if ($sub && !($sub->subscribepackage->name === 'custom' || $sub->subscribepackage->id == 99))
                                    @if (
                                        $payment &&
                                            $payment->status == 'pending' &&
                                            $ceksub->account_status == 'non-aktif' &&
                                            $sub &&
                                            \Carbon\Carbon::parse($sub->created_at)->toDateString() === now()->toDateString())
                                        <div class="alert alert-danger alert-dismissible">
                                            <div class="container">
                                                <p> Anda Memiliki Tagihan Pembayaran Yang Belum Diselesaikan Klik Tombol
                                                    Berikut Untuk Melihat Pembayaran Anda <br>
                                                    <a href="{{ route('customer/langganan.qris', $payment->user_id) }}"
                                                        class="btn btn-primary mt-2">Payment</a>
                                                </p>
                                            </div>
                                        </div>
                                    @elseif($payment && $payment->status == 'pending' && $sub && $sub->account_status == 'non-aktif')
                                        <div class="alert alert-info alert-dismissible">
                                            <div class="container">
                                                <p> Kamu belum berlangganan, mari mulai berlangganan untuk menikmati fitur
                                                    dari kami <br>
                                                    <a href="{{ route('customer/langganan.upgrade') }}"
                                                        class="btn btn-primary mt-2">Mulai Berlangganan</a>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    @if (
                                        $sub &&
                                            now()->diffInDays(\Carbon\Carbon::parse($sub->end_date)) <= 5 &&
                                            $payment &&
                                            $payment->status == 'completed')
                                        <div class="alert alert-danger alert-dismissible">
                                            <div class="container">
                                                <p> Waktu Langganan Anda Akan Segera Habis, Silahkan Perpanjang Waktu
                                                    Langganan Anda <br>
                                                    <a href="{{ route('customer/langganan.upgrade') }}"
                                                        class="btn btn-primary mt-2">Perpanjang Langganan</a>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @elseif(
                                    $sub &&
                                        $sub->subscribepackage->name === 'custom' &&
                                        $sub->subscribepackage->id == 99 &&
                                        now()->diffInDays(\Carbon\Carbon::parse($sub->end_date)) <= 1 &&
                                        $payment &&
                                        $payment->status == 'completed')
                                    <div class="alert alert-danger alert-dismissible">
                                        <div class="container">
                                            <p> Waktu Percobaan Anda Akan Segera Habis, Silahkan Update Langganan Anda <br>
                                                <a href="{{ route('customer/langganan.upgrade') }}"
                                                    class="btn btn-primary mt-2">Perpanjang Langganan</a>
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
                                        @if (now()->diffInDays(\Carbon\Carbon::parse($sub->end_date)) >= 0 &&
                                                ($sub->subscribepackage->name === 'custom' || $sub->subscribepackage->id == 99))
                                            <h3>Anda sedang menikmati akun percobaan</h3>
                                            <h5 class="my-3">
                                                <p>Akun Percobaan Berakhir pada
                                                    {{ \Carbon\Carbon::parse($sub->end_date)->format('d F Y') }}</p>
                                            </h5>
                                            <p> <a href="{{ route('customer/langganan.index') }}"
                                                    class="btn btn-primary">langganan Sekarang</a> </p>
                                        @elseif(\Carbon\Carbon::parse($sub->end_date) < now())
                                            <h3 style="text:red">Anda Belum Berlangganan</h3>
                                            <h5 class="my-3">Pilih Paket Untuk Menikmati Layanan Kami</h5>
                                            <p> <a href="{{ route('customer/langganan.index') }}"
                                                    class="btn btn-primary">langganan Sekarang</a> </p>
                                        @elseif(\Carbon\Carbon::parse($sub->end_date) >= now() && $payment->status == 'completed')
                                            <h3>Data Langganan Anda</h3>
                                            <h2> {{ $sub->subscribepackage->name }}</h2>
                                            <p>Berakhir pada {{ \Carbon\Carbon::parse($sub->end_date)->format('d F Y') }}
                                            </p>
                                        @elseif(\Carbon\Carbon::parse($sub->end_date) >= now() && $sub->account_status == 'aktif')
                                            <h3>Data Langganan Anda</h3>
                                            <h2> {{ $sub->subscribepackage->name }}</h2>
                                            <p>Berakhir pada {{ \Carbon\Carbon::parse($sub->end_date)->format('d F Y') }}
                                            </p>
                                        @elseif(\Carbon\Carbon::parse($sub->end_date) >= now() && $sub->account_status == 'non-aktif')
                                            <h3 style="text:red">Anda Belum Berlangganan</h3>
                                            <h5 class="my-3">Pilih Paket Untuk Menikmati Layanan Kami</h5>
                                            <p> <a href="{{ route('customer/langganan.index') }}"
                                                    class="btn btn-primary">langganan Sekarang</a> </p>
                                        @endif
                                    @else
                                        <h3 style="text:red">Anda Belum Berlangganan</h3>
                                        <h5 class="my-3">Pilih Paket Untuk Menikmati Layanan Kami</h5>
                                        <p> <a href="{{ route('customer/langganan.index') }}"
                                                class="btn btn-primary">langganan Sekarang</a> </p>
                                    @endif
                                </div>
                            </div><!-- End Service Item -->
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="service-item position-relative">
                                    <h3>Komisi Anda</h3>
                                    <h2 class="mb-3">Rp {{ number_format($komisi, 0, ',', '.') }} </h2>
                                    <a href="{{ route('customer/affiliasi.index') }}"
                                        class="btn btn-primary rounded btn-sm text-white">Mulai Dapatkan Komisi</a>
                                </div>
                            </div><!-- End Service Item -->
                        </div>
                    </div>
                    <div class="container py-3">
                        <div class="row justify-content-center">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="service-item position-relative" style="border:1px">
                                    <h3> Ekstensi </h3>
                                    @if ($files)
                                        @foreach ($files as $file)
                                            @if ($file->type === 'extension')
                                                <a href="{{ asset('storage') }}/{{ $file->file_location }}"
                                                    target="_blank" download="">
                                                    <h5 class="pt-3 px-2"><i class="bi bi-download"></i> Unduh
                                                        {{ $file->name }}</h5>
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="service-item position-relative" style="border:1px">
                                    <h3> Video </h3>
                                    @if ($videos)
                                        @foreach ($videos as $video)
                                            <h5 class="py-1 px-2" data-bs-toggle="modal" data-bs-target="#globalModal"
                                                data-id="{{ $video->id }}" data-url="{{ $video->link }}"
                                                data-title="{{ $video->name }}" style="cursor: pointer;"><i
                                                    class="bi bi-play-fill"></i> {{ $video->name }}</h5>
                                            </h5>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            @if (optional($bonus)->bonus)
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="service-item position-relative" style="border:1px">
                                        <h3> Bonus </h3>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <center>#</center>
                                                    </th>
                                                    <th>
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Password</center>
                                                    </th>
                                                    <th>
                                                        <center>File</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <center>{{ $bonus->bonus->name }}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{ $bonus->bonus->username }}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{ $bonus->bonus->password }}</center>
                                                    </td>
                                                    <td> <a href="{{ asset('storage') }}/{{ $bonus->bonus->file_location }}"
                                                            target="_blank" download="">
                                                            <h6 class="pt-3 px-2">
                                                                <center><i class="bi bi-download"></i> Unduh
                                                                    {{ $bonus->bonus->name }}</center>
                                                            </h6>
                                                        </a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @elseif($bonus_global)
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="service-item position-relative" style="border:1px">
                                        <h3> Bonus </h3>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <center>#</center>
                                                    </th>
                                                    <th>
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Password</center>
                                                    </th>
                                                    <th>
                                                        <center>File</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <center>{{ $bonus_global->name }} </center>
                                                    </td>
                                                    <td>
                                                        <center>{{ $bonus_global->username }}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{ $bonus_global->password }}</center>
                                                    </td>
                                                    <td> <a href="{{ asset('storage') }}/{{ $bonus_global->file_location }}"
                                                            target="_blank" download="">
                                                            <h6 class="pt-3 px-2">
                                                                <center><i class="bi bi-download"></i> Unduh
                                                                    {{ $bonus_global->name }}</center>
                                                            </h6>
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
                @php
                    $akunIds = [];
                    if ($user->akun_id) {
                        $akunIds = $user->akun_id;
                    }
                    $universityNames = App\Models\UniversityAccount::with('university')
                        ->whereIn('id', $akunIds)
                        ->get()
                        ->pluck('university.name');
                    $univAcc = App\Models\UniversityAccount::with('university')->whereIn('id', $akunIds)->first();
                    $univAccs = App\Models\UniversityAccount::with('university')->whereIn('id', $akunIds)->get();

                    $univNameLower = $universityNames->map(fn($name) => strtolower($name));

                    $airlanggaAccs = App\Models\UniversityAccount::with('university')
                        ->whereIn('id', $akunIds)
                        ->whereHas('university', function ($query) {
                            $query->where('name', 'Universitas Airlangga');
                        })
                        ->get();
                    $univAirlangga = $airlanggaAccs->first()?->username;
                    $arizonaAccs = App\Models\UniversityAccount::with('university')
                        ->whereIn('id', $akunIds)
                        ->whereHas('university', function ($query) {
                            $query->where('name', 'Arizona State University');
                        })
                        ->get();
                    $univArizona = $arizonaAccs->first()?->username;

                    $username_arizona = $univArizona;
                    $username_unair = $univAirlangga;

                    $arizona = App\Models\ConfigAccount::where('username', $username_arizona)->first();
                    $unair = App\Models\ConfigAccount::where('username', $username_unair)->first();

                    $arizonaTrim = '';
                    $unairTrim = '';

                    if ($arizona?->name_config || $unair?->name_config) {
                        $arizonaTrim = $arizona?->name_config ?? '';
                        $unairTrim = Str::replace('.ovpn', '', $unair?->name_config ?? '');
                    }

                @endphp

                @if ($sub && \Carbon\Carbon::parse($sub->end_date) >= now() && $sub->account_status == 'aktif')
                    <section id="database" class="about section">
                        <div class="container section-title" data-aos="fade-up">
                            <h2 class="my-auto">Databases</h2>
                            <a href="https://unairsatu.unair.ac.id/" style="display: none;">Akses</a>
                        </div>
                        <div class="container section-title" data-aos="fade-up" id="uc_login_database">
                            <a href="#database" class="btn btn-primary" id="db_login" style="display: none;"> Login
                                Database</a>
                            <p class="text-danger fs-5 mt-3 fw-bold" id="pesan">Silahkan menginstall Agent (khusus
                                windows) dan Ekstensi terlebih dahulu! pastikan versi yang terbaru</p>
                        </div>
                        <div class="container section-title" data-aos="fade-up" id="uc_logout_database">
                            <a href="#database" class="btn btn-danger" id="db_logout" style="display: none;"> Logout
                                Database</a>
                        </div>

                        <div class="d-flex justify-content-center p-2">
                            <div>
                                <p id="jalankan" style="display: none;">Jalankan otomatisasi:</p>
                                @if (Str::contains($univNameLower, 'cincinnati'))
                                    <a href="#database" class="btn btn-primary" id="uc_login"
                                        style="display: none;">CINCINNATI</a>
                                @endif
                                @if (Str::contains($univNameLower, 'arizona'))
                                    <a href="#database" class="btn btn-primary" id="con_ASU_1"
                                        style="display: none;">ARIZONA</a>
                                @endif
                                @if (Str::contains($univNameLower, 'auraria'))
                                    <a href="#database" class="btn btn-primary" id="auraria"
                                        style="display: none;">AURARIA</a>
                                @endif
                                @if (Str::contains($univNameLower, 'oakland'))
                                    <a href="#database" class="btn btn-primary" id="oakland"
                                        style="display: none;">OAKLAND</a>
                                @endif
                                @if (Str::contains($univNameLower, 'airlangga'))
                                    <a href="#database" class="btn btn-primary" id="con_UNAIR_1"
                                        style="display: none;">UNAIR</a>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-center p-2">
                            <div>
                                <p id="hentikan" style="display: none;">Berhentikan otomatisasi:</p>
                                <a href="#database" class="btn btn-danger" id="dis_ASU_1"
                                    style="display: none;">ARIZONA_1</a>
                                <a href="#database" class="btn btn-danger" id="dis_UNAIR_1"
                                    style="display: none;">UNAIR_1</a>
                                <a href="#database" class="btn btn-danger" id="dis_UNAIR_2"
                                    style="display: none;">UNAIR_2</a>
                                <a href="#database" class="btn btn-danger" id="dis_UNAIR_3"
                                    style="display: none;">UNAIR_3</a>
                                <a href="#database" class="btn btn-danger" id="dis_UNAIR_4"
                                    style="display: none;">UNAIR_4</a>
                            </div>
                        </div>

                        <div id="status"><center>Status: Menunggu perintah...</center></dopeiv>

                        <div class="container" id="listdatabase" style="display: none;">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 content">
                                    <div class="container mt-4">
                                        <div class="category-filter">
                                            <select id="categoryFilter" class="form-control">
                                                <option value="show" hidden selected class="bg-muted text-secondary"><i
                                                        class="fas fa-filter"></i> Filter by University</option>
                                                <option value="">Show All</option>
                                                {{-- @foreach ($univs as $univ)
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
                                                    $univId = App\Models\UniversityAccount::with('university')
                                                        ->whereIn('id', $akunIds)
                                                        ->get()
                                                        ->pluck('university.id');
                                                    $websitesUniv = App\Models\UniversityWebsite::with('university')
                                                        ->whereIn('university_id', $univId)
                                                        ->get();
                                                @endphp
                                                <tbody>
                                                    @foreach ($websitesUniv as $wu)
                                                        <tr>
                                                            <td class="text-nowrap">
                                                                @if ($wu->university->parent == 0 || $wu->university->parent === null)
                                                                    {{ $wu->university->name ?? 'Tidak Diketahui' }}
                                                                @elseif($wu->university->parent != 0 && $wu->university->parent !== null)
                                                                    {{ \App\Models\University::where('id', $wu->university->parent)->first()->name ?? 'Tidak Diketahui' }}
                                                                @endif
                                                            </td>
                                                            <td class="text-nowrap">
                                                                <a href="{{ $wu->url }}" id="{{ $wu->flag_id }}"
                                                                    onclick="automateLogin('{{ $wu->flag_id }}')"
                                                                    target="_blank">
                                                                    {!! $wu->title . ' <i class="fa-solid fa-up-right-from-square"></i>' ?? 'Tidak Diketahui' !!}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    {{-- @foreach ($websites as $index => $web)
                    <tr>
                        <td class="text-nowrap">
                          @if ($web->university->parent == 0 || $web->university->parent === null)
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
                    <iframe id="globalIframe" src="" width="100%" height="600px"
                        style="border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    @include('customer.js')
@endpush
