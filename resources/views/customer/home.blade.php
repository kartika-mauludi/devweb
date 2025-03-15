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

    <!-- Services Section -->
    <section id="kelebihan" class="services section light-background">

      <!-- Section Title -->
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-6">
            <div class="service-item position-relative">
              <h4>Data Langganan Anda</h4>
              <h2>1 Bulan</h2>
              <p>Berakhir pada 27 March 2025, 15:57 (WIB).</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-5 col-lg-6 col-md-6">
            <div class="service-item position-relative">
              <h4>Komisi Anda</h4>
              <h2 class="mb-3">Rp</h2>
              <button class="btn btn-primary rounded btn-sm text-white">Mulai Datapkan Komisi</button> <button class="btn btn-primary text-white rounded btn-sm">Tarik Komisi</button>
            </div>
          </div><!-- End Service Item -->
        </div>

      </div>

    </section><!-- /Services Section -->


    <!-- About Section -->
    <section id="tentang" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2 class="my-auto">Databases</h2>
      </div><!-- End Section Title -->

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10 content">
            <!-- search card -->
          <div class="row justify-content-center bg-light rounded bg-light border border-1 shadow-sm p-3 my-5">
            <div class="col">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            </div>
            <div class="col">
                <select class="js-example-basic-single select2-container--default" style="width:100%;" name="state">
                    <option class="select2-selection--single" value="AL">Universitas 1</option>
                    <option class="select2-selection--single" value="WY">Universitas 2</option>
                    <option class="select2-selection--single" value="WY">Universitas 3</option>
                </select>
            </div>
            <div class="col">
                <select class="js-example-basic-single" style="width:100%;" name="state">
                    <option value="AL">Alabama</option>
                        ...
                    <option value="WY">Wyoming</option>
                </select>
            </div>
            <div class="col">
                <select class="js-example-basic-single" style="width:100%;" name="state">
                    <option value="AL">Alabama</option>
                        ...
                    <option value="WY">Wyoming</option>
                </select>
            </div>
            <div class="col d-grid gap-2 mx-auto">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </div>
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


  </main>
