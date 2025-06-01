@extends('customer.asset')

@section('content')

<div class="container my-5">
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
        </ol>
      </nav>
      <!-- /Breadcrumb -->

      <div class="row gutters-sm">
        <div class="col-md-4 d-none d-md-block">
          <div class="card">
            <div class="card-body">
              <nav class="nav flex-column nav-pills nav-gap-y-1">
                <a href="#profil" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded @if(!session('active')) active @else  @endif">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Informasi Profil
                </a>
                <a href="#akun" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded {{ (session('active') == '1') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings mr-2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>Pengaturan Akun
                </a>
                <a href="#keamanan" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded {{ (session('active') == '2') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield mr-2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>Pengaturan Keamanan
                </a>
               
                <a href="#tagihan" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded {{ (session('active') == '3') ? 'active' : '' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card mr-2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>Tagihan
                </a>
              </nav>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header border-bottom mb-3 d-flex d-md-none">
              <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                <li class="nav-item">
                  <a href="#profil" data-toggle="tab" class="nav-link has-icon @if(!session('active')) active @else  @endif"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></a>
                </li>
                <li class="nav-item">
                  <a href="#akun" data-toggle="tab" class="nav-link has-icon {{ (session('active') == '1') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></a>
                </li>
                <li class="nav-item">
                  <a href="#keamanan" data-toggle="tab" class="nav-link has-icon {{ (session('active') == '2') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></a>
                </li>
             
                <li class="nav-item">
                  <a href="#tagihan" data-toggle="tab" class="nav-link has-icon {{ (session('active') == '3') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></a>
                </li>
              </ul>
            </div>
            <div class="card-body tab-content">
                @if (session('message'))
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ session('message') }}
                    </div>
                @endsession
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ session('error') }}
                    </div>
                @endsession

              <div class="tab-pane @if(!session('active')) active @else  @endif" id="profil">
                <h4>Informasi Profil</h4>
                <hr>
                <form>
                  <div class="form-group">
                    <label for="fullName">Nama</label>
                    <input type="text" class="form-control" id="fullName" aria-describedby="fullNameHelp" placeholder="Enter your fullname" value="{{ $user->name }}" readonly>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" value="{{ $user->email }}" readonly>
                  </div>
                  <div class="form-group">
                    <label for="nomor">Nomor Whatsapp</label>
                    <input type="text" class="form-control" id="nomor" value="{{ $user->nomor }}" readonly>
                  </div>
                  <div class="form-group">
                    <label for="nomor">Nomor Rekening</label>
                    <input type="text" class="form-control" id="rekening" value="{{ $user->bank_account }}" readonly>
                  </div>
                  <div class="form-group">
                    <label for="namarek">Nama Akun Rekening</label>
                    <input type="text" class="form-control" id="rekening" value="{{ $user->bank_name_account }}" readonly>
                  </div>
                  <div class="form-group">
                    <label for="namabank">Nama Bank</label>
                    <input type="text" class="form-control" id="bank"  value="{{ $user->bank_name }}" readonly>
                  </div>
                </form>
              </div>
              <div class="tab-pane {{ (session('active') == '1') ? 'active' : '' }}" id="akun">
                <h4>Pengaturan Akun</h4>
                <hr>
                <form method="POST" action="{{ $url }}">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="fullName">Nama</label>
                    <input type="text" class="form-control" name="name" id="fullName" aria-describedby="fullNameHelp" placeholder="Enter your fullname" value="{{ $user->name }}">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" value="{{ $user->email }}" readonly>
                  </div>
                  <div class="form-group">
                    <label for="nomor">Nomor Whatsapp</label>
                    <input type="text" class="form-control" id="nomor" name="nomor" value="{{ $user->nomor }}" oninput="this.value = this.value.replace(/\D/g, '+')">
                  </div>
                  <div class="form-group">
                    <label for="nomor">Nomor Rekening</label>
                    <input type="text" class="form-control" id="rekening" name="rekening" value="{{ $user->bank_account }}" oninput="this.value = this.value.replace(/\D/g, '')" placeholder="contoh : 5126411">
                  </div>
                  <div class="form-group">
                    <label for="nomor">Nama Akun Rekening</label>
                    <input type="text" class="form-control" id="akunbank" name="akunbank" value="{{ $user->bank_name_account }}">
                  </div>
                  <div class="form-group">
                    <label for="nomor">Nama Bank</label>
                    <input type="text" class="form-control" id="bank" name="bank" value="{{ $user->bank_name }}" placeholder="contoh : BCA">
                  </div>
                  <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
              </div>
              <div class="tab-pane {{ (session('active') == '2') ? 'active' : '' }}" id="keamanan">
                <h4>Pengaturan Keamanan</h4>
                <hr>
                <form method="POST" action="{{ $passurl }}">
                    @csrf
                    {{ method_field('PUT') }}
                  <div class="form-group">
                    <label class="d-block">Change Password</label>
                    <input type="password" class="form-control @error('passwordold') is-invalid @enderror" name="passwordold" placeholder="Enter your old password">
                        @error('passwordold')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    <input type="password" class="form-control mt-1 @error('password') is-invalid @enderror" name="password" placeholder="New password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    <input type="password" class="form-control mt-1" name="password_confirmation"placeholder="Confirm new password">
                  </div>
                  <button type="submit" class="btn btn-primary">Ubah Password</button>
                </form>
                <hr>
               
              </div>
             
              <div class="tab-pane {{ (session('active') == '3') ? 'active' : '' }}" id="tagihan">
                <h4>Tagihan</h4>
                <hr>
                <form>
                  <div class="form-group">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="simple-tab-0" data-bs-toggle="tab" href="#simple-tabpanel-0" role="tab" aria-controls="simple-tabpanel-0" aria-selected="true">Langganan</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="simple-tab-1" data-bs-toggle="tab" href="#simple-tabpanel-1" role="tab" aria-controls="simple-tabpanel-1" aria-selected="false">Faktur</a>
                    </li>
                    </ul>
                    <div class="tab-content pt-2" id="tab-content">
                        <div class="tab-pane active" id="simple-tabpanel-0" role="tabpanel" aria-labelledby="simple-tab-0">
                            Langganan Aktif
                            <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Tanggal Mulai</th>
                                <th scope="col">Tanggal Selesai</th>
                                <th scope="col">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($subscribes as $sub)
                               @if($sub->account_status === "aktif")
                                <tr>
                                <td scope="row">{{ $sub->subscribePackage->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($sub->start_date)->format("d F Y") }}</td>
                                <td>{{ \Carbon\Carbon::parse($sub->end_date)->format("d F Y")}}</td>
                                <td>Rp.{{ number_format($sub->subscribePackage->price , 0, ",", ".") }}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            </table>
                            <p>
                              <a data-bs-toggle="collapse" href="#riwayat" role="button" aria-expanded="false" aria-controls="riwayat">
                              Riwayat Langganan
                              </a>
                            </p>
                          <div class="collapse" id="riwayat">
                            <div class="card card-body">
                            <div class="table-responsive-md">
                            <table id="list-riwayat" class="table">
                            <thead>
                                <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Tanggal Mulai</th>
                                <th scope="col">Tanggal Selesai</th>
                                <th scope="col">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($subscribes as $sub)
                              @if($sub->account_status === "non-aktif")
                                <tr>
                                <td scope="row">{{ $sub->subscribePackage->name }}</td>
                                <td>{{ $sub->start_date != Null ? \Carbon\Carbon::parse($sub->start_date)->format("d F Y"):"------" }}</td>
                                <td>{{ $sub->end_date != Null ? \Carbon\Carbon::parse($sub->end_date)->format("d F Y"):"------" }}</td>
                                <td>Rp.{{ number_format($sub->subscribePackage->price , 0, ",", ".") }}</td>
                                </tr>
                                @endif
                              @endforeach
                             
                            </tbody>
                            </table>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="simple-tabpanel-1" role="tabpanel" aria-labelledby="simple-tab-1">
                          Faktur
                          <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($subscribes as $sub)
                               <tr>
                                @php $jml = $loop->iteration - 1 @endphp
                                  <td scope="row">@if($jml >= 0){{ $user->payments[$jml]->id_invoice ?? ''  }} @endif</td>
                                  <td>@if($jml >= 0){{ $user->payments[$jml]->status ?? '' }} @endif </td> 
                                  <td>{{ date_format($sub->created_at, "d F Y")}}</td>
                                  <td>Rp.{{ number_format($sub->subscribePackage->price , 0, ",", ".") }}</td>
                                  <td> <button onclick="openPrintPage({{ $user->id }},{{ $sub->id }})"><i class="fa-solid fa-download"></i></button> </td>  
                              </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>


  <script>
  $(document).ready(function() {
  $('#list-riwayat').DataTable({
    searching: false
  });
});

    function openPrintPage(id_user, id_sub) {
        // window.open('', '_blank');
        let url = "{{ route('customer/profil.invoice', ['id_user' => ':id_user', 'id_sub' => ':id_sub']) }}";
        url = url.replace(':id_user', id_user).replace(':id_sub', id_sub);
        window.open(url, '_blank');
    }
</script>

@endsection

