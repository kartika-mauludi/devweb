@extends('customer.asset')

@section('content')

<main class="main">
<div class="container my-5">
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0">Beranda</a></li>
          <li class="breadcrumb-item active" aria-current="page">Langganan</li>
        </ol>
      </nav>
      <!-- /Breadcrumb -->
        <div class="col-md-12">
          <div class="card">
            <div class="card-header border-bottom mb-3 d-flex d-md-none">
            </div>
            <div class="card-body tab-content">
              <div class="tab-pane active" id="profile">
                <h4>Informasi Langganan</h4>
                <hr>

                @if ($langganan)                    
                  <form>
                    <div class="form-group">
                      <label for="fullName">Paket Langganan</label>
                      <input type="text" class="form-control" id="paket" aria-describedby="paket" placeholder="Enter your fullname" value="{{ $langganan->subscriberecord->subscribepackage->name }}" readonly>
                      <small id="fullNameHelp" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                      <label for="bio">Tanggal Langganan</label>
                      <input type="text" class="form-control" id="tanggal" aria-describedby="tanggal" placeholder="Enter your fullname" value="{{ ($langganan->subscriberecord->start_date == null) ? 'Menunggu Pembayaran': \Carbon\Carbon::parse($langganan->subscriberecord->start_date)->format("d F Y") }}" readonly>
                      </div>
                      <div class="form-group">
                      <label for="bio">Tanggal Kadaluarsa</label>
                      <input type="text" class="form-control" id="tanggal" aria-describedby="tanggal" placeholder="Enter your fullname" value="{{ ($langganan->subscriberecord->end_date == null) ? 'Menunggu Pembayaran': \Carbon\Carbon::parse($langganan->subscriberecord->end_date)->format("d F Y") }}" readonly>
                      </div>
                    <div class="form-group">
                      <label for="url">Status</label>
                      <input type="text" class="form-control" id="url" value="{{ $langganan->status }}" readonly>
                    </div>
                    <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary">Ubah Paket</a>
                  </form>
                @else
                <div class="text-center mt-3">
                  <h5 class="text-muted">Anda belum memiliki paket yang aktif, silahkan aktivasi terlebih dahulu</h5>
                  <a href="{{ route('customer/langganan.upgrade') }}" class="btn btn-primary mt-3">Tambah Paket</a>
                </div>
                @endif
              </div>
            
          </div>
        </div>
      </div>

    </div>


@endsection