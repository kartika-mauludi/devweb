@extends('customer.asset')

@section('content')

<main class="main">
<div class="container my-5">
<nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0">Beranda</a></li>
          <li class="breadcrumb-item active" aria-current="page">Langganan</li>
        </ol>
      </nav>

    <form class="needs-validation" method="POST" action="{{ route('customer/langganan.subscriber') }}">
     @csrf
      <div class="row justify-content-center p-3">
        <!-- Data Diri -->
        <div class="col-md-7 col-lg-7 col-sm-12 p-5 border border-1 shadow-sm bg-light m-2">
          <h4 class="mb-3 text-primary">Data Diri</h4>
            <div class="row g-3">
              <div class="col-sm-12">
                <label for="firstName" class="form-label">Nama Lengkap</label>
                <input type="text" name="name"class="form-control" id="nama"  value="{{ auth::user()->name }}" readonly>
              </div>
              <div class="col-12">
                <label for="email" class="form-label">Alamat Email <span class="text-muted"></span></label>
                <input type="email" name="email"  class="form-control "  value="{{ auth::user()->email }}" readonly>
              </div>
              <div class="col-12">
                <label for="nomor" class="form-label">Nomor Whatsapp<span class="text-muted"></span></label>
                <input type="tel" name="nomor"  class="form-control" id="nomor" value="{{ auth::user()->nomor }}" readonly >
              </div>
            
          </div>
        </div>
        <!-- end of data diri -->
        <!-- Detail Pemesanan  -->
         {{ Session::put('id', $pack->id) }}
         {{ Session::put('price', $pack->price) }}
         {{ Session::put('discount', $pack->discount) }}
        <div class="col-md-4 col-lg-4 col-sm-10 order-md-last bg-light shadow-sm m-2 p-5 border border-1">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Detail Paket</span>
            <span class="badge bg-primary rounded-pill"></span>
          </h4>
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0">Pilihan Paket</h6>
                <small class="text-muted">{{ $pack->name }}</small>
              </div>
              <span class="text-muted">Rp.</sup>{{ number_format($pack->price , 0, ",", ".")}}</span>
            </li>
        
            <li class="list-group-item d-flex justify-content-between">
              <span>Total </span>
              <strong>Rp.</sup>{{ number_format(($pack->price - $pack->diskon) , 0, ",", ".")}}</strong>
            </li>
          </ul>
            <div class="input-group">
            <button class="w-100 btn btn-primary btn-lg rounded" type="submit">Perbarui Langganan</button>
            <a href="{{ route('customer/langganan.upgrade') }}" class="w-100 btn btn-success btn-lg mt-3 rounded" type="submit">Ubah Paket</a>
            </div>
        </div>
        <!-- end of detail pemesanan -->
      </div>
      </form>
  </main>
</div>