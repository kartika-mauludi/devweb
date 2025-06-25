@extends('admin.layout.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 form-group">
                            <label for="name" class="form-label">Bonus</label>
                            <input type="text" id="name" class="form-control form-control-sm" value="{{ $record->name ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="file" class="form-label">File</label>
                            <input type="text" id="file" class="form-control form-control-sm" value="{{ $record->file_location ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" class="form-control form-control-sm" value="{{ $record->username ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" id="password" class="form-control form-control-sm" value="{{ $record->password ?? '' }}" readonly>
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
                                                <form action="{{ route('bonus.destroy.detail', $detail->id ?? '') }}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
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