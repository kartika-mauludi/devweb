@extends('customer.asset')

@section('content')
  
  
  <!-- <main class="main"> -->
    <!-- Services Section -->
    <section  class="services section light-background">
      <!-- Section Title -->
      <div class="container my-5">
        <div class="row justify-content-center">
      
        @if (session('message'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             Penarikan dana sebesar   Rp. {{ number_format( session(key: 'amount') , 0, ",", ".") }} sedang di proses, proses akan dilakukan diwaktu jam kerja
            </div>
        @endsession

        <!-- @if (session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('message') }}
            </div>
        @endsession -->


                <div class="col-xl-12 col-lg-12 col-md-12 mb-4">
                    <div class="service-item position-relative">
                      <h3>Total Komisi Rp. <span> {{  number_format( $paid->sum('amount') + $pending->sum('amount') - $wd->sum('amount')  , 0, ",", ".") }} </span> </h3>
                      <h5 id="link">Link Afiliasi Anda :  <span id="pwd_spn" class="link-span"><a href="">{{  route('refferal', ['ref' => auth()->user()->referral_code]) }}</a></span>
                        <div class="tooltip2">
                          <button class="btn btn-success text-white rounded btn-sm" onclick="copy()" onmouseout="outFunc()">
                          <span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
                          Copy Link
                          </button>
                        </div>   
                      </h5>
                      @if ($komisi)  
                        <h5>Dapatkan @if($komisi->type == 'fixed') Rp. {{  number_format(optional($komisi)->amount ?? 10000 , 0, ",", ".") }} @elseif($komisi->type == 'percentage') {{  number_format(optional($komisi)->amount ?? 10000 , 0, ",", ".") }}% @endif untuk setiap teman yang berhasil memulai langganan bulan pertama mereka melalui Anda! </h5>
                      @else
                        <h5>Dapatkan komisi untuk setiap teman yang berhasil memulai langganan bulan pertama mereka melalui Anda!</h5>
                      @endif
                    </div>
                </div><!-- End Service Item --> 
              
        <div class="col-xl-6 col-lg-6 col-md-6 mb-3">
            <div class="service-item position-relative">
              <h4>Komisi Pending</h4>
              <h2>Rp <span> {{  number_format($pending->sum('amount') , 0, ",", ".")  }} </span></h2>
              <p>Affiliasi anda belum menyelesaikan pembayaran</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-6 col-lg-6 col-md-6 mb-3">
            <div class="service-item position-relative">
              <h4>Komisi Paid ( Bisa Ditarik )</h4>
              <h2 class="mb-3"><span id="balance" data-value="{{ $paid->sum('amount') - $wd->sum('amount') }}"></span></h2>
              <button type="button" class="btn btn-primary text-white rounded btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tarik Komisi
              </button>
            </div>
          </div><!-- End Service Item -->
        </div>
      </div>
    </section><!-- /Services Section -->
<!-- Button trigger modal -->

<!-- Modal Notif -->
 @if($paid->sum('amount') - $wd->sum('amount') < 100000)
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Penarikan Ditolak</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Saldo Komisi Harus Lebih Dari Rp. 100.000 Untuk Bisa Di Tarik
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--  end Modal Notif  -->

@elseif($paid->sum('amount') - $wd->sum('amount') > 100000)
<!-- Modal withdraw -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Penarikan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('customer/affiliasi.store',['ref' => auth()->user()->referral_code]) }}" method="POST" onsubmit="return validateWithdrawal(event)">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label for="nomor">Jumlah Penarikan</label>
          <input type="text" name="amount" class="form-control" id="withdrawAmount"  oninput="this.setCustomValidity('');checkWithdrawalAmount()" required  oninvalid="this.setCustomValidity('Nominal Penarikan Harus Di Isi')">
          <small>Jumlah penarikan tidak bisa lebih dari saldo komisi</small>
        </div>
        <Label>Data Bank</Label>
        <div class="form-group">
          <label for="nomor">Nomor Rekening</label>
          <input type="text" class="form-control" id="rekening" value="{{ auth::user()->bank_account }}" readonly>
        </div>
        <div class="form-group">
          <label for="nomor">Nama Bank</label>
          <input type="text" class="form-control" id="bank"  value="{{ auth::user()->bank_name }}" readonly>
        </div>
        <small>Pastikan data bank anda sudah sesuai, jika belum silahkan ke menu profil untuk mengubah data bank anda</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Ajukan Penarikan</button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- end modal withdraw -->
   @endif

  </main>

<script>
 const MIN_WITHDRAWAL = 100000;
function copy() {
    var span = document.getElementById("pwd_spn");
    var copyText = document.createElement("textarea");
    copyText.value = span.textContent;
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);

    var tooltip = document.getElementById("myTooltip");
    tooltip.innerHTML = "Copied: " + copyText.value;
}

function outFunc() {
    var tooltip = document.getElementById("myTooltip");
    tooltip.innerHTML = "Copy to clipboard";
}

function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        // Fungsi untuk memperbarui tampilan saldo
        function updateBalanceDisplay() {
            let balance = parseFloat(document.getElementById("balance").dataset.value);
            document.getElementById("balance").innerText = formatRupiah(balance);
        }

        // Fungsi untuk memeriksa jumlah penarikan saat input berubah
        function checkWithdrawalAmount() {
            let availableBalance = parseFloat(document.getElementById("balance").dataset.value);
            let withdrawInput = document.getElementById("withdrawAmount");

            let withdrawAmount = parseFloat(withdrawInput.value.replace(/\D/g, '')); // Hanya angka
            withdrawInput.value = formatRupiah(withdrawAmount);

            if (isNaN(withdrawAmount) || withdrawAmount < 0) {
                withdrawInput.value = "";
                return;
            }

            if (withdrawAmount > availableBalance) {
                withdrawInput.value = formatRupiah(availableBalance);
                alert("Saldo tidak mencukupi!");
            }

        }

        function validateWithdrawal(event){

            let availableBalance = parseFloat(document.getElementById("balance").dataset.value);
            let withdrawInput = document.getElementById("withdrawAmount");
            let hiddenInput = document.getElementById("hiddenWithdrawAmount");
            let withdrawAmount = parseFloat(withdrawInput.value.replace(/\D/g, '')); // Ambil nilai asli dari input hidden
             let rekening = document.getElementById("rekening");
             let bank = document.getElementById("bank");

            if (withdrawAmount <= 0) {
                alert("Masukkan jumlah yang valid!");
                event.preventDefault(); // Mencegah pengiriman form
                return false;
            }

            if (withdrawAmount < MIN_WITHDRAWAL) {
                alert(`Minimal penarikan adalah ${formatRupiah(MIN_WITHDRAWAL)}!`);
                event.preventDefault();
                return false;
            }

            if (rekening.value.trim() === "" || bank.value.trim() === "" ) {
                alert("Nomor Rekening atau Bank tidak boleh kosong silahkan update data diri terlebih dahulu");
                return false;
            }
          
            return true; // Biarkan form terkirim
        }

        window.onload = updateBalanceDisplay;

</script>
  @endsection
