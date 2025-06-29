@extends('admin.layout.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ $url }}" method="post">
                        @csrf
                        @if (isset($record))
                            @method('PUT')
                        @endif
        
                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ $record->name ?? '' }}" required placeholder="contoh : bambang">
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control form-control-sm" value="{{ $record->email ?? '' }}" required placeholder="contoh : example@gmail.com">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="nomor" class="form-label">Nomor Telpon</label>
                                <input type="text" name="nomor" id="nomor" class="form-control form-control-sm" value="{{ $record->nomor ?? '' }}" placeholder="+62xxxxxxx">
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control form-control-sm" @if(!isset($record)) required @endif>
                                @if(isset($record))
                                    <span class="text-muted">kosongkan jika tidak merubah password</span>
                                @endif
                            </div>
                        </div>

                        <label for="">Data Bank</label>

                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="bank_name" class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control form-control-sm" value="{{ $record->bank_name ?? '' }}" placeholder="contoh : BCA">
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="bank_name" class="form-label">Atas Nama Rekening</label>
                                <input type="text" name="bank_name_account" id="bank_name_account" class="form-control form-control-sm" value="{{ $record->bank_name_account ?? '' }}" placeholder="contoh : bambang">
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="bank_account" class="form-label">Bank Account</label>
                                <input type="number" name="bank_account" id="bank_account" class="form-control form-control-sm" value="{{ $record->bank_account ?? '' }}" placeholder="Contoh : 7312313">
                            </div>
                        </div>

                       

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-sm btn-success">{{ $label }}</button>
                                <a href="{{ $prev }}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection