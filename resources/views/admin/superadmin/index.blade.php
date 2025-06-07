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
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#setting">Setting</button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Nomor Telepon</th>
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
                                    <td>{{ $record->nomor }}</td>
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

<!-- Modal Tambah -->
<div class="modal fade" id="setting" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setting  Email dan Nomor WA</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('superadmin.config') }}" method="POST" id="addsetting">
                @csrf
                <div class="modal-body">
                    @if($config)
                      <input type="hidden" name="id" value="{{ $config->id }}">
                    @endif
                <div class="form-group">
                        <label>Email</label>
                        <select name="email" id="type" class="form-control">
                             <option value="">-- Pilih Email --</option>
                             @foreach ($records as $record)
                             <option value="{{ $record->email }}" @if($config)@selected($config->email == ($record->email ?? ''))@endif>{{ $record->email }}</option>
                             @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor Wa</label>
                        <select name="nomor" id="type" class="form-control">
                             <option value="">-- Pilih Nomor --</option>
                             @foreach ($records as $record)
                             <option value="{{ $record->nomor }}" @if($config)@selected($config->nomor == ($record->nomor ?? ''))@endif>{{ $record->nomor }}</option>
                             @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        $('.datatable').DataTable();

        $(document).ready(function () {

            $('#addsetting').on('submit', function (e) {
            e.preventDefault();
            showLoading();
            var formData = new FormData($(this)[0])

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function (response) {
                    closeLoading();
                    if (response.status == 200) {
                        Swal.fire('Berhasil!', response.message, 'success').then(() => {
                            window.location.reload();;
                    });
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                    $('#setting').modal('hide');
                    $('#addsetting').trigger('reset'); 
                },
                error: function () {
                    closeLoading();
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menambah data.', 'error');
                }
            });
        });
        });
    </script>
@endpush