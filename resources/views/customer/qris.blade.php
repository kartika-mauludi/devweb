@extends('customer.asset')
@section('content')

<main class="hero row justify-content-center">
<div class="col-md-4 col-lg-4 col-sm-8 order-md-last bg-light shadow-sm m-2 p-5 border border-1">
    @if($pack->account_status == "non-aktif")
    <div class="text-center mt-3">
         <h4 class="d-flex justify-content-center mb-3">
            <span class="text-primary">Detail Pembayaran</span>
            <span class="badge bg-primary rounded-pill"></span>
          </h4>
          <h5 class="d-flex justify-content-center mb-3">
            <span class="text-primary">Afib Rulyansah</span>
            <span class="badge bg-primary rounded-pill"></span>
          </h5>
          <h5 class="d-flex justify-content-center mb-3">
            <span class="text-primary">No Invoice : {{ $pack->payments->first()->id_invoice }}</span>
            <span class="badge bg-primary rounded-pill"></span>
          </h5>
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
        <a href="https://wa.me/{{ \App\Models\ConfigAdmin::first()->nomor ?? '+6285236868125'}}" class="btn btn-success mt-3">Kirim Bukti Transfer</a>
        <button class="btn btn-primary mt-3" type="button" id="reloadPage" >Cek Status Pembayaran</button>
      </div>
    </div>
    @elseif($pack->account_status == "aktif")
    <script>
      window.onload = function() {
      window.location.href = "{{ route('customer.home') }}";
    };
  </script>
    @endif
</main>

@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const reloadBtn = document.getElementById("reloadPage");
    if (reloadBtn) {
      reloadBtn.addEventListener("click", function () {
        fetch("{{ route('customer/langganan.qris_response', $pack->user_id) }}")
      .then(response => response.json())
      .then(data => {
      if (data.status) {
        console.log("Status Pembayaran:", data.status);
        if (data.status === "aktif") {
          Swal.fire({
            icon: 'success',
            title: 'Pembayaran Berhasil',
            text: 'Silakan lanjutkan ke halaman berikutnya!',
          }).then(() => {
            window.location.href = "{{ route('customer.home') }}";
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Pembayaran Belum Terkonfirmasi',
            text: 'Silahkan kirim bukti ke admin',
          });
        }
    } else {
      console.error("Data status tidak ditemukan.");
    }
  })
  .catch(error => console.error("Gagal fetch JSON:", error));
      });
    }
  });
</script>




