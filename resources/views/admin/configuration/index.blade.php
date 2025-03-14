@extends('admin.layout.index')

@section('content')
<div class="row">
    <div class="col-12">
        @if (session('message'))
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('message') }}
            </div>
        @endsession

        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Konfigurasi Komisi</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control form-control-sm" value="{{ $commisions->amount ?? '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" name="type" id="type" class="form-control form-control-sm" value="{{ $commisions->type ?? '' }}" readonly>
                        </div>
        
                        <a href="{{ route('commision-config.setting') }}" class="btn btn-sm btn-success mt-3">Setting</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Konfigurasi Midtrans</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="environment" class="form-label">Environment</label>
                            <input type="text" name="environment" id="environment" class="form-control form-control-sm" value="{{ $midtrans->environment ?? '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="sandbox_client_key" class="form-label">Sandbox client key</label>
                            <input type="text" name="sandbox_client_key" id="sandbox_client_key" class="form-control form-control-sm" value="{{ $midtrans->sandbox_client_key ?? '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="sandbox_server_key" class="form-label">Sandbox server key</label>
                            <input type="text" name="sandbox_server_key" id="sandbox_server_key" class="form-control form-control-sm" value="{{ $midtrans->sandbox_server_key ?? '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="production_client_key" class="form-label">Production client key</label>
                            <input type="text" name="production_client_key" id="production_client_key" class="form-control form-control-sm" value="{{ $midtrans->production_client_key ?? '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="production_server_key" class="form-label">Production server key</label>
                            <input type="text" name="production_server_key" id="production_server_key" class="form-control form-control-sm" value="{{ $midtrans->production_server_key ?? '' }}" readonly>
                        </div>
        
                        <a href="{{ route('midtrans-config.setting') }}" class="btn btn-sm btn-success mt-3">Setting</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection