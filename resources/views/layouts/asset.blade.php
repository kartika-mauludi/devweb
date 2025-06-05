<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Databaseriset</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

   <!-- Vendor CSS Files -->
   <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Favicons -->
  <link rel="icon" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
  <link rel="icon" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css')}}" rel="stylesheet">
 
 <style>
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
      
      @media(max-width:768px){
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

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top" style="background-color:#0135A3;">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('icons/logo.png') }}" class="logo" alt="">
        <!-- <h1 class="sitename">Databaseriset</h1> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ url('/#beranda') }}" class="active">Beranda</a></li>
          <li><a href="{{ url('/#kelebihan') }}">Kelebihan</a></li>
          <li><a href="{{ url('/#tentang') }}">Tentang Kami</a></li>
          <li><a href="{{ url('/#harga') }}">Harga</a></li>
          <li><a href="{{ url('/#layanan') }}">Layanan</a></li>
          <li><a href="{{ route('login') }}" class="login-a">Masuk</a></li>
          <li><a href="{{ url('/#harga') }}" id="menu-mobile">Coba Sekarang</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth

                                @if(auth::user()->is_superadmin == 1)
                                    <a href="{{ url('/admin/home')}}" class="btn-getstarted">
                                @elseif(auth::user()->is_superadmin == 0)
                                <a href="{{ url('/customer/home') }}" class="btn-getstarted">
                                    @endif
                                        Dashboard
                                    </a>
                                   
                                @else
                                <a class="btn-login" href="{{ route('login') }}">Masuk</a>
                              
                                <a class="btn-getstarted" id="menu-dekstop" href="{{ url('/#harga') }}">Coba Sekarang</a>
                                 
                                @endauth
                            </nav>
                        @endif
    </div>
  </header>
  <a href="https://wa.me/{{ $user->nomor ?? "+6285236868125"}}" target="_blank" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-whatsapp"></i></a>


  @yield('content')
<footer id="footer" class="footer">
    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename">Databaseriset</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
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
          <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
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
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>