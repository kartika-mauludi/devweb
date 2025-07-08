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
                <a href="{{ route('package.create') }}" class="btn btn-sm btn-success">Tambah</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Days</th>
                                <th class="notexport">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                @if($record->name != "custom" && $record->id != 99)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $record->name }}</td>
                                    <td>{{ $record->price }}</td>
                                    <td>{{ $record->discount }}</td>
                                    <td>{{ $record->days }}</td>
                                    <td>
                                        <form action="{{ route('package.destroy', $record->id) }}" onsubmit="return confirm('Apakah anda yakin ?')" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <div class="btn-group">
                                                <a href="{{ route('package.edit', $record->id) }}" class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        var table = $('.datatable').DataTable({
            layout: {
                topStart: {
                    buttons: [
                        'pageLength',
                        {
                            extend: 'excel',
                            text: 'download',
                            title: 'Databaseriset - Data Paket Langganan',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        }
                    ]
                }
            }
        })
    </script>
@endpush