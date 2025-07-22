<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Databaseriset</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link rel="icon" sizes="32x32" href="{{ asset('icons/icondatabaseriset.png') }}">
  <link rel="icon" sizes="16x16" href="{{ asset('icons/icondatabaseriset.png') }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('customer/main.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
  <!-- Select -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      /* select2 styling */
      .select2-container--default .select2-selection--single{
          padding:6px;
          height: 37px;
          width: 100%;
          position: relative;
          border:solid 1px #DEE2E6;
          background-color: #fff;
      }

      select.form-control{
        display: inline;
        width: 200px;
        margin-left: 25px;
      }

      .dataTables_filter {
          float: right;
          text-align: right;
      }

      body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;    
}
.main-body {
    padding: 15px;
}

.nav-link {
    color: #4a5568;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}

.tooltip2 {
  position: relative;
  display: inline-block;
}

.tooltip2 .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip2 .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip2:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}

.bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      #menu-dekstop {
        display: inline;
      }

      #menu-mobile {
          display: none;
        }

      .logo-img{
        width: 180px;
      }
      @media(max-width:1080px){
        .header .logo {
          order: 1;
        }
        #menu-dekstop {
          display: none;
        }

        #menu-mobile {
          display: flex;
        }

        
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

<style>
.tooltip {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: auto;
  background-color: #555;
  color: #fff;
  text-align: center;
  padding: 4px 8px;
  border-radius: 5px;
  position: absolute;
  z-index: 1;
  bottom: 125%; /* di atas elemen */
  left: 50%;
  transform: translateX(-50%);
  opacity: 0;
  transition: opacity 0.3s;
  white-space: nowrap;
}

.tooltip:hover .tooltiptext,
.tooltip.active .tooltiptext {
  visibility: visible;
  opacity: 1;
}

.footer .footer-contact a {
        margin-right: 3px;
        font-size: 12px;
        line-height: 0;
        color: color-mix(in srgb, var(--default-color), transparent 20%);
      }
</style>

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top" style="background-color:#0135A3;">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.webp" alt=""> -->
        <!-- <h1 class="sitename">Databaseriset</h1> -->
        <img class="logo-img" src="{{ asset('icons/logo-light.png') }}"  alt="">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ url('/customer/home') }}" class=" @if(Route::is('customer.home')) active @endif">Beranda</a></li>
          <li><a href="{{ route('customer/langganan.index') }}" class=" @if(Route::is('customer/langganan.*')) active @endif">Langganan</a></li>
          <li><a href="{{ route('customer/affiliasi.index') }}"  class=" @if(Route::is('customer/affiliasi.*')) active @endif">Affiliasi</a></li>
          <li><a href="https://wa.me/{{ \App\Models\User::with('config')->find(optional(\App\Models\ConfigAdmin::first())->nomor)->nomor ?? '+6285236868125'}}" target="_blank">Bantuan</a></li>
          <li class="dropdown"><a href="#" class=" @if(Route::is('customer/profil.*')) active @endif"><span>{{ auth::user()->name ?? '' }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul style="right: 0; left: auto;">
              <li style="display: flex; flex-direction: row;"><a class="bi bi-person-fill fs-5" href="{{ route('customer/profil.show',auth::user()->id) }}">
                <span style="font-size: 0.9rem !important;" class="mx-2">Profil</span>
                </a></li>
              <li style="display: flex; flex-direction: row;">
                   <a class="bi bi-box-arrow-right fs-5" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                     <!-- {{ __('Logout') }}  -->
                       <span style="font-size: 0.9rem !important;" class="mx-2">Logout</span>
                  </a> 
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>     
              </li>
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
    
  </header>
  <div id="installer-status" style="
    background-color: #f8d7da;
    color: #721c24;
    padding: 12px;
    font-weight: bold;
    text-align: center;
    display: none;">
</div>
  <a href="https://wa.me/{{ \App\Models\User::with('config')->find(optional(\App\Models\ConfigAdmin::first())->nomor)->nomor ?? '+6285236868125'}}" target="_blank" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-whatsapp"></i></a>
  @yield('content')




  <footer id="footer" class="footer">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ url('/') }}" class="d-flex align-items-center">
            <span class="sitename">Databaseriset</span>
          </a>
          <div class="footer-contact pt-1">
            <p class="mt-1"><strong>Phone:</strong> <span> <a href="https://wa.me/{{ \App\Models\User::with('config')->find(optional(\App\Models\ConfigAdmin::first())->nomor)->nomor ?? '+6285236868125'}}" target="_blank" >{{ \App\Models\User::with('config')->find(optional(\App\Models\ConfigAdmin::first())->nomor)->nomor ?? '+6285236868125'}}</a></span></p>
            <p><strong>Email:</strong> <span><a href="mailto:info@databaseriset.com">info@databaseriset.com</a></span></p>
          </div>
        </div>

        <div class="col-lg-4 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ url('/#beranda') }}" >Beranda</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ url('/#kelebihan') }}">Kelebihan</a></li>
            <li><i class="bi bi-chevron-right"></i><a href="{{ url('/#tentang') }}">Tentang Kami</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ url('/#layanan') }}">Layanan</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <div class="social-links d-flex">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-2">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Databaseriset</strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('customer/js/x-frame-bypass.js') }}"></script>
  <script src="https://unpkg.com/@ungap/custom-elements-builtin"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js" ></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <!-- Select -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

  @stack('script')


<script>
const sessionLifetimeMinutes = {{ config('session.lifetime') }};
const sessionLifetimeMs = sessionLifetimeMinutes * 60 * 1000;


function logout() {
    alert("Session expired. You will be logged out.");
    document.getElementById('logout-form').submit();
}

let timeout = setTimeout(logout, sessionLifetimeMs);

// Reset timer saat user aktif
['click', 'mousemove', 'keypress', 'scroll'].forEach(event => {
    document.addEventListener(event, () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            alert("Session expired. You will be logged out.");
            window.location.href = "";
        }, sessionLifetimeMs);
    });
});


  fetch("http://localhost:54321")
    .then(res => res.json())
    .then(data => {
      if (data.status === "installed") {
        alert("tes");
      }
    })
    .catch(() => {
      alert("❌ Installer belum dijalankan., Jalankan Installer Untuk Mengakses Database");
      // $("#database").hide();
  });

</script>
</body>

</html>