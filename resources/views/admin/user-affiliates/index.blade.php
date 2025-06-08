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
                <a href="{{ route('user-affiliates.create') }}" class="btn btn-sm btn-success">Tambah</a>
            </div>

            <div class="card-body">
                <label for="">Withdraw Request</label>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover datatable-request">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="notexport">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $record->user->name }}</td>
                                    <td>Rp.{{ number_format($record->amount , 0, ",", ".")}}</td>
                                    <td>
                                        @if ($record->status == 'pending')
                                            <span class="badge badge-secondary">{{ $record->status }}</span>
                                        @elseif ($record->status == 'withdraw')
                                            <span class="badge badge-primary">{{ $record->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('user-affiliates.destroy', $record->id) }}" onsubmit="return confirm('Apakah anda yakin ?')" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-success" @if($record->status == 'withdraw') onclick="proceedWithdraw('{{ $record->id }}', '{{ $record->user_id }}', '{{ $record->amount }}')" @endif>
                                                    Proses
                                                </button>
                                                <a @if($record->status == 'withdraw') href="{{ route('user-affiliates.edit', $record->id) }}" @else href="#" @endif class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                                <button @if($record->status == 'withdraw') type="submit" @else type="button" @endif class="btn btn-sm btn-danger">
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
                <div class="card-body">
                <label for="">Withdraw Success</label>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover datatable-success">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="notexport">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($success as $record)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $record->user->name }}</td>
                                    <td>Rp.{{ number_format($record->amount , 0, ",", ".")}}</td>
                                    <td>
                                        @if ($record->status == 'pending')
                                            <span class="badge badge-secondary">{{ $record->status }}</span>
                                        @elseif ($record->status == 'success')
                                            <span class="badge badge-success">{{ $record->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('user-affiliates.destroy', $record->id) }}" onsubmit="return confirm('Apakah anda yakin ?')" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <div class="btn-group">
                                                <!-- <button type="button" class="btn btn-sm btn-success" @if($record->status == 'withdraw') onclick="proceedWithdraw('{{ $record->id }}', '{{ $record->user_id }}', '{{ $record->amount }}')" @endif>
                                                    Proses
                                                </button>
                                                <a @if($record->status == 'pending') href="{{ route('user-affiliates.edit', $record->id) }}" @else href="#" @endif class="btn btn-sm btn-warning">
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

<div class="modal" id="proceedModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proses Withdraw</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div div class="modal-body">
                <p class="fw-semibold">Customer <br>
                <span class="text-muted" id="name"></span></p>
                <p class="fw-semibold">Nama Bank <br>
                <span class="text-muted mt-0" id="bank_name"></span></p>
                <p class="fw-semibold">Atas Nama Rekening <br>
                <span class="text-muted mt-0" id="bank_name_account"></span></p>
                <p class="fw-semibold">Nomor Rekening <br>
                <span class="text-muted" id="bank_account"></span></p>
                <p class="fw-semibold">Amount <br>
                <span class="text-muted" id="amount"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="" class="btn btn-primary" id="proceedUrl" onclick="return confirm('Apakah anda yaking ?')">Proses</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $('.datatable-request').DataTable({
        layout: {
            topStart: {
                buttons: [
                    'pageLength',
                    {
                        extend: 'excel',
                        text: 'download',
                        title: 'Databaseriset - Data Withdraw Request',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    }
                ]
            }
        }
    })

    $('.datatable-success').DataTable({
        layout: {
            topStart: {
                buttons: [
                    'pageLength',
                    {
                        extend: 'excel',
                        text: 'download',
                        title: 'Databaseriset - Data Withdraw Success',
                        exportOptions: {
                            columns: ':not(.notexport)'
                        }
                    }
                ]
            }
        }
    })

    function proceedWithdraw(id, userId, amount){
        let url = "{{ route('customer.show', ":userId") }}"
        let url2= "{{ route('user-affiliates.proceed', ":id") }}"
        url     = url.replace(":userId", userId)
        url2    = url2.replace(":id", id)

        $.ajax({
            url: url,
            method: "get",
            success: function(data) {
                $('#name').html(data['name'])
                $('#bank_name').html(data['bank_name'])
                $('#bank_name_account').html(data['bank_name_account'])
                $('#bank_account').html(data['bank_account'])
                $('#amount').html(amount)
                $('#proceedUrl').attr('href', url2)
                
                $('#proceedModal').modal('show')
            },error: function(error) {
                console.log(error);
                alert('Terjadi kesalahan sistem, hubungi administrator')
            }
        })
    }
</script>
@endpush