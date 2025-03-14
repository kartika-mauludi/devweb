@extends('layouts.asset')

@section('content')

<div class="mt-5 pt-5"></div>
<div class="py-5 text-center">
<h1>Masuk Ke Akun Kamu</h1>
</div>
<div class="container mt-1 pb-5 ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required  oninvalid="this.setCustomValidity('Email Harus di Isi')" autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 d-grid mx-auto">
                                <button type="submit" class="btn btn-primary">
                                   Masuk
                                </button>          
                        </div>
                    </form>
                    <div  class="pt-3 text-center">  
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Lupa Password?') }}
                                    </a>
                                @endif
                            </div></div>
                    <div class=" text-center">Belum Punya Akun ? <a href="{{ url('/#harga') }}">Daftar Sekarang</a> </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
