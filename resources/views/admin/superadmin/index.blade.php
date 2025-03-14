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
        <div class="card">
            <div class="card-header">
                <a href="{{ route('superadmin.create') }}" class="btn btn-sm btn-success">Tambah</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Reff. Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $record->name }}</td>
                                    <td>{{ $record->email }}</td>
                                    <td>{{ $record->referral_code }}</td>
                                    <td>
                                        <form action="{{ route('superadmin.destroy', $record->id) }}" onsubmit="return confirm('Apakah anda yakin ?')" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <div class="btn-group">
                                                <a href="{{ route('superadmin.show', $record->id) }}" class="btn btn-sm btn-info">
                                                    Detail
                                                </a>
                                                <a href="{{ route('superadmin.edit', $record->id) }}" class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
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
        </div>
    </div>
</div>
@endsection