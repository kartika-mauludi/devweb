@extends('admin.layout.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 form-group">
                            <label for="amount" class="form-label">Besaran</label>
                            <input type="number" id="amount" class="form-control form-control-sm" value="{{ $record->amount ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" id="type" class="form-control form-control-sm" value="{{ $record->type ?? '' }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>No. Telpon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($record->details as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->user->name ?? '' }}</td>
                                            <td>{{ $detail->user->email ?? '' }}</td>
                                            <td>{{ $detail->user->nomor ?? '' }}</td>
                                            <td>
                                                <form action="{{ route('configuration.destroy.detail', $detail->id) }}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
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
                            <a href="{{ $url }}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="{{ $prev }}" class="btn btn-sm btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection