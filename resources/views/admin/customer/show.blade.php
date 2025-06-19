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
                            <label for="nomor" class="form-label">Nomor Telpon</label>
                            <input type="text" name="nomor" id="nomor" class="form-control form-control-sm" value="{{ $record->nomor ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="referral_code" class="form-label">Reff. Code</label>
                            <input type="text" name="referral_code" id="referral_code" class="form-control form-control-sm" value="{{ $record->referral_code ?? '' }}" readonly>
                        </div>
                    </div>

                    <label for="">Data Bank</label>

                    <div class="row">
                        <div class="col-12 col-sm-6 form-group">
                            <label for="bank_name" class="form-label">Nama Bank</label>
                            <input type="text" name="bank_name" id="bank_name" class="form-control form-control-sm" value="{{ $record->bank_name ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="bank_name_account" class="form-label">Atas Nama Rekening</label>
                            <input type="text" name="bank_name_account" id="bank_name_account" class="form-control form-control-sm" value="{{ $record->bank_name_account ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="bank_account" class="form-label">Nomor Rekening</label>
                            <input type="number" name="bank_account" id="bank_account" class="form-control form-control-sm" value="{{ $record->bank_account ?? '' }}" readonly>
                        </div>
                    </div>

                    <label for="">Langganan</label>

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-sm table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Package</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Status</th>
                                        <th class="notexport">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribes as $record)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $record->user->name ?? '' }}</td>
                                            <td>{{ $record->user->email ?? '' }}</td>
                                            <td>{{ $record->user->nomor ?? '' }}</td>
                                            <td>{{ $record->subscribePackage->name ?? '' }}</td>
                                            <td>{{ $record->start_date }}</td>
                                            <td>{{ $record->end_date }}</td>
                                            <td data-filter="{{ $record->account_status }}">
                                                @if ($record->account_status == 'aktif')
                                                    <span class="badge badge-success">{{ $record->account_status }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $record->account_status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('package-record.destroy', $record->id) }}" onsubmit="return confirm('Apakah anda yakin ?')" method="post">
                                                    @csrf
                                                    @method('DELETE')
        
                                                    <div class="btn-group">
                                                      
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('package-record.edit', $record->id) }}" class="btn btn-sm btn-success">
                                                            Tambah Langganan
                                                        </a>
                            <!-- <a href="{{ $url }}" class="btn btn-sm btn-warning">Edit</a> -->
                            <a href="{{ $prev }}" class="btn btn-sm btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection