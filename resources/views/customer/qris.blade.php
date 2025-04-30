@extends('customer.asset')
@section('content')

<main class="hero row justify-content-center">
<div class="col-md-4 col-lg-4 col-sm-8 order-md-last bg-light shadow-sm m-2 p-5 border border-1">
    <div class="text-center mt-3">
         <h4 class="d-flex justify-content-center mb-3">
            <span class="text-primary">Detail Pembayaran</span>
            <span class="badge bg-primary rounded-pill"></span>
          </h4>
        <img src="{{ asset('assets/img/QR-Code.jpg') }}" width="150px" height="150px" alt="">
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0">Pilihan Paket</h6>
                <small class="text-muted">{{ $pack->subscribepackage->name }}</small>
              </div>
              <span class="text-muted">Rp.</sup>{{ number_format($pack->subscribepackage->price , 0, ",", ".")}}</span>
            </li>
        
            <li class="list-group-item d-flex justify-content-between">
              <span>Total </span>
              <strong>Rp.</sup>{{ number_format(($pack->subscribepackage->price - $pack->subscribepackage->diskon) , 0, ",", ".")}}</strong>
            </li>
          </ul>
          <h6>Scan Qris di atas dan bayar sesuai total harga paket, setelah selesai konfirmasi pembayaran anda dengan mengirim screnn shot dari pembarayan anda</h6>
        <a href="https://wa.me/{{ $user->nomor ?? "+6285236868125" class="btn btn-success mt-3">Kirim Bukti Transfer</a>
    </div>
    </div>
</main>


@endsection

