@extends('layouts.asset')

@section('content')

<div class="container mt-5 pt-3 mb-5">
  <main>
    <div class="pt-5 text-center">
      <!-- <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
      <h1 class="mt-5">Paket Pilihan Anda</h1>
      <p class="lead">Isi data diri anda</p>
    </div>

       @if (session('message'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('message') }}
            </div>
        @endsession

    <form class="needs-validation" method="POST" action="{{ route('registrasi') }}">
     @csrf
      <div class="row justify-content-center p-3">
        <!-- Data Diri -->
        <div class="col-md-7 col-lg-7 col-sm-8 p-5 border border-1 shadow-sm bg-light m-2">
          <h4 class="mb-3 text-primary">Data Diri</h4>
            <div class="row g-3">
              <div class="col-sm-12">
                <label for="firstName" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="nama" placeholder="Contoh : Bambang " value="" required  oninvalid="this.setCustomValidity('Nama Harus di Isi')" oninput="this.setCustomValidity('')">
                @error('name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              <div class="col-12">
                <label for="email" class="form-label">Alamat Email <span class="text-muted"></span></label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required  oninvalid="this.setCustomValidity('Email Harus di Isi')" oninput="this.setCustomValidity('')" id="email" placeholder="you@email.com">
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              <div class="col-12">
                <label for="nomor" class="form-label">Nomor Whatsapp<span class="text-muted"></span></label>
                <input type="tel" name="nomor" value="{{ old('nomor') }}" class="form-control @error('nomor') is-invalid @enderror" id="nomor" oninput="this.value = this.value.replace(/\D/g, '+');this.setCustomValidity('')" maxlength="15" placeholder="08xxxxxxxxx" required  oninvalid="this.setCustomValidity('Nomor Harus di Isi')">
                  @error('nomor')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              <div class="col-12">
                <label for="address" class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              <div class="col-12">
                <label for="address2" class="form-label"> Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" id="konfirmasi">
              </div>
            <hr class="my-4">
          </div>
        </div>
        <!-- end of data diri -->
        <!-- Detail Pemesanan  -->
        {{ Session::put('id', $pack->id) }}
         {{ Session::put('ref', request('ref')) }}
         {{ Session::put('price', $pack->price) }}
         {{ Session::put('discount', $pack->discount) }}

        <div class="col-md-4 col-lg-4 col-sm-8 order-md-last bg-light shadow-sm m-2 p-5 border border-1">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Detail Pemesanan</span>
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
            <button class="w-100 btn btn-primary btn-lg rounded" type="submit">Daftar</button>
            <a href="{{ url('/#harga') }}" class="w-100 btn btn-success btn-lg mt-3 rounded" type="submit">Ubah Paket</a>
            </div>
        </div>
        <!-- end of detail pemesanan -->
      </div>
      </form>
  </main>
</div>

@endsection