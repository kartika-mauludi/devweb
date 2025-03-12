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
        </div>
    </div>
</div>
@endsection