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
                                <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ $record->name ?? '' }}" required>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control form-control-sm" value="{{ $record->email ?? '' }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="nomor" class="form-label">Nomor Telpon</label>
                                <input type="text" name="nomor" id="nomor" class="form-control form-control-sm" value="{{ $record->nomor ?? '' }}">
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

                        <hr>

                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="bank_name" class="form-label">Nama Bank</label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control form-control-sm" value="{{ $record->bank_name ?? '' }}" >
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="bank_name" class="form-label">Atas Nama Rekening</label>
                                <input type="text" name="bank_name_account" id="bank_name_account" class="form-control form-control-sm" value="{{ $record->bank_name_account ?? '' }}" >
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="bank_account" class="form-label">Nomor Rekening</label>
                                <input type="number" name="bank_account" id="bank_account" class="form-control form-control-sm" value="{{ $record->bank_account ?? '' }}" >
                            </div>                           
                        </div>

                        <label for="">Data Langganan</label>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="package_id" class="form-label">Paket Langganan</label>
                                <select name="package_id" id="package_id" class="form-control form-control-sm" @required(!isset($record))>
                                    <option value=""></option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}"  @if(isset($subscribe))@selected($subscribe->subscribe_package_id == ($package->id ?? ''))@endif >{{ $package->name.' - '.$package->price }}</option>
                                    @endforeach
                                </select>
                                <small>Pilih Custom jika ingin custom end date(langganan)</small>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ $subscribe->start_date ?? 0.00 }}" @required(!isset($record))>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="start_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ $subscribe->end_date ?? 0.00 }}">
                                <small>Biarkan Kosong Jika Tidak Ada Custom</small>
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