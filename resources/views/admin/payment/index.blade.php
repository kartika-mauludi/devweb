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
                    <table class="table table-sm table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Id Invoice</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
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
                                    <td>{{ $record->subscribeRecord->user->name ?? '' }}</td>
                                    <td>{{ $record->subscribeRecord->user->email ?? '' }}</td>
                                    <td>{{ $record->subscribeRecord->user->nomor ?? '' }}</td>
                                    <td>{{ $record->subscribeRecord->subscribePackage->name ?? '' }}</td>
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
                                                <button type="button" class="btn btn-sm btn-info showBtn" data-id="{{ $record->id }}">
                                                    Detail
                                                </button>
                                                <!-- <a @if($record->status == 'pending') href="{{ route('payment.edit', $record->id) }}" @else href="#" @endif class="btn btn-sm btn-warning">
                                                    Edit
                                                </a> -->
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

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="" id="paymentForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col">
                            <label for="id_invoice">Id Invoice</label>
                            <input type="text" id="id_invoice" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="form-group col">
                            <label for="user">Customer</label>
                            <input type="text" id="user" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="package">Package</label>
                            <input type="text" id="package" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="form-group col">
                            <label for="price">Price</label>
                            <input type="text" id="price" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="discount">Diskon</label>
                            <input type="text" id="discount" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="form-group col">
                            <label for="total">Total</label>
                            <input type="text" id="total" class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Konfirm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $('.datatable').DataTable()

        $('.datatable').on('click', '.showBtn', function(){
            paymentId = $(this).data('id')
            url = `payment/show/${paymentId}`

            $.get(url, function (payment) {
                $('#id_invoice').val(payment['record']['id_invoice'])
                $('#user').val(payment['record']['user'])
                $('#package').val(payment['record']['package'])
                $('#price').val(payment['record']['price'])
                $('#discount').val(payment['record']['discount'])
                $('#total').val(payment['record']['total'])

                $('#paymentForm').attr('action', payment['url'])
            });

            $('#paymentModal').modal('show');
        })
    </script>
@endpush