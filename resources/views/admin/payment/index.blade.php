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
                <a href="{{ route('payment.create') }}" class="btn btn-sm btn-success">Tambah</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Id Invoice</th>
                                <th>Customer</th>
                                <th>Package</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $record->id_invoice }}</td>
                                    <td>{{ $record->subscribeRecord->user->name }}</td>
                                    <td>{{ $record->subscribeRecord->subscribePackage->name }}</td>
                                    <td>{{ $record->grandtotal() }}</td>
                                    <td>
                                        @if ($record->status == 'pending')
                                            <span class="badge badge-secondary">{{ $record->status }}</span>
                                        @elseif ($record->status == 'completed')
                                            <span class="badge badge-success">{{ $record->status }}</span>
                                        @elseif ($record->status == 'failed')
                                            <span class="badge badge-danger">{{ $record->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('payment.destroy', $record->id) }}" onsubmit="return confirm('Apakah anda yakin ?')" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <div class="btn-group">
                                                <a href="{{ route('payment.show', $record->id) }}" class="btn btn-sm btn-info">
                                                    Detail
                                                </a>
                                                <a @if($record->status == 'pending') href="{{ route('payment.edit', $record->id) }}" @else href="#" @endif class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                                <button @if($record->status == 'pending') type="submit" @else type="button" @endif class="btn btn-sm btn-danger">
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