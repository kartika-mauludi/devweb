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
                <a href="{{ route('package-record.create') }}" class="btn btn-sm btn-success">Tambah</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Package</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $record->user->name ?? '' }}</td>
                                    <td>{{ $record->subscribePackage->name ?? '' }}</td>
                                    <td>{{ $record->start_date }}</td>
                                    <td>{{ $record->end_date }}</td>
                                    <td>
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
                                                <a href="{{ route('package-record.edit', $record->id) }}" class="btn btn-sm btn-warning">
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

@push('script')
    <script>
        $('.datatable').DataTable()
    </script>
@endpush