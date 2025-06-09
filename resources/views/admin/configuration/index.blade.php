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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('configuration.create') }}" class="btn btn-sm btn-success">Tambah</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Besaran</th>
                                    <th>Tipe</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($commisions as $commision)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $commision->amount }}</td>
                                        <td>{{ $commision->type }}</td>
                                        <td>
                                            <form action="{{ route('configuration.destroy', $commision->id) }}" method="post" onsubmit="return confirm('Apakah anda yakin ?')">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('configuration.show', $commision->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                                <a href="{{ route('configuration.edit', $commision->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
</div>
@endsection