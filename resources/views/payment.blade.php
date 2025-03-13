@extends('layouts.asset')

@section('content')



<div class="container mt-5 pt-3 mb-5 ">
  <main>
    <div class="py-5 text-center">
      <!-- <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
      <h1>Paket Pilihan Anda</h1>
      <p class="lead">Isi data diri anda</p>
    </div>
    <form class="needs-validation" novalidate>
    <div class="row g-5 ">
      <div class="col-md-5 col-lg-4 col-sm-8 order-md-last bg-light ms-4 pt-4 border border-3">
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
          <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
          <button class="w-100 btn btn-success btn-lg mt-3" type="submit">Ubah Paket</button>
          </div>

      </div>

      <div class="col-md-7 col-lg-7 col-sm-8 pt-4 border border-3 bg-light">
        <h4 class="mb-3">Data Diri</h4>
     
          <div class="row g-3">
            <div class="col-sm-12">
              <label for="firstName" class="form-label">Nama Lengkap</label>
              <input type="text" name="nama" class="form-control" id="nama" placeholder="" value="" required>
              <div class="invalid-feedback">
                Nama masih kosong
              </div>
            </div>
            <div class="col-12">
              <label for="email" class="form-label">Alamat Email <span class="text-muted">(Optional)</span></label>
              <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label"> Konfirmasi Password</label>
              <input type="password" name="konfirmasi" class="form-control" id="konfirmasi">
            </div>
          <hr class="my-4">
        </form>
      </div>
    </div>
  </main>
</div>