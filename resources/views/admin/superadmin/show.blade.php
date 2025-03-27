@extends('admin.layout.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ $record->name ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" id="email" class="form-control form-control-sm" value="{{ $record->email ?? '' }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 form-group">
                            <label for="bank_account" class="form-label">Bank Account</label>
                            <input type="number" name="bank_account" id="bank_account" class="form-control form-control-sm" value="{{ $record->bank_account ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="bank_name" class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" id="bank_name" class="form-control form-control-sm" value="{{ $record->bank_name ?? '' }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 form-group">
                            <label for="nomor" class="form-label">Nomor Telpon</label>
                            <input type="text" name="nomor" id="nomor" class="form-control form-control-sm" value="{{ $record->nomor ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="referral_code" class="form-label">Reff. Code</label>
                            <input type="text" name="referral_code" id="referral_code" class="form-control form-control-sm" value="{{ $record->referral_code ?? '' }}" readonly>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ $url }}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="{{ $prev }}" class="btn btn-sm btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection