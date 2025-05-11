@extends('admin.layout.index')

@section('content')
<div class="row">
    <div class="col-12">

        @if (session('message'))
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('message') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addUniversityModal">Tambah</button>
            </div>

            <div class="p-3 table-responsive">
                <table id="tbl-university" class="table table-sm table-bordered table-hover datatable w-100">
                    <thead>
                        <tr>
                            <th class="fit text-center">No.</th>
                            <th>Nama Universitas</th>
                            <th>Main URL</th>
                            <th>Signin URL</th>
                            <th>Signout URL</th>
                            <th>Batasan Penggunaan Akun</th>
                            <th class="fit text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addUniversityModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Universitas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('universities.store') }}" method="POST" id="addUniversityForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Universitas</label>
                        <input type="text" name="name" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Main URL</label>
                        <input type="url" name="main_url" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Signin URL</label>
                        <input type="url" name="signin_url" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Signout URL</label>
                        <input type="url" name="signout_url" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Batassan Penggunaan Akun</label>
                        <input type="number" name="batasan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Parent Universitas</label>
                        <select name="parent" id="parent" class="form-control">
                             <option value="">-- Pilih Universitas parent --</option>
                             <option value="0">-- Tidak Ada Parent --</option>
                             @foreach ( $universitas as $univ )
                            <option value="{{ $univ->id }}"> {{ $univ->name }} </option>
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

<!-- Modal Edit -->
<div class="modal fade" id="editUniversityModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Universitas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="editUniversityForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_id">
                    <div class="form-group">
                        <label>Nama Universitas</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Main URL</label>
                        <input type="url" name="main_url" id="edit_main_url" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Signin URL</label>
                        <input type="url" name="signin_url" id="edit_signin_url" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Signout URL</label>
                        <input type="url" name="signout_url" id="edit_signout_url" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Batassan Penggunaan Akun</label>
                        <input type="number" name="batasan" id="batasan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Parent Universitas</label>
                        <select name="parent" id="editparent" class="form-control">
                             <option value="">-- Pilih Universitas --</option>
                             <option value="0">-- Tidak Ada Parent --</option>
                             @foreach ( $universitas as $univ )
                                <option value="{{ $univ->id }}" @if(isset($university) && $univ->id == $university->parent) selected @endif>
                                {{ $univ->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function () {
        var table = $('#tbl-university').DataTable({
            processing: true,
            ordering: false,
            serverSide: false,
            ajax: "{{ route('universities.data') }}",
            columns: [
                { 
                    data: null, render: (data, type, row, meta) => {
                        return `<div class="text-center">${meta.row + 1}.</div>`;
                    } 
                },
                { 
                    data: 'name', 
                    render: (data, type, row) => `<a href="{{ url('/universities' )}}/${row.id}" class="text-nowrap">${data}</a>`
                },
                { 
                    data: 'main_url', 
                    render: (data) => data ? `<a href="${data}" target="_blank">${data}</a>` : '-'
                },
                { 
                    data: 'signin_url', 
                    render: (data) => data ? `<a href="${data}" target="_blank">${data}</a>` : '-'
                },
                { 
                    data: 'signout_url', 
                    render: (data) => data ? `<a href="${data}" target="_blank">${data}</a>` : '-'
                },
                { 
                    data: 'batasan', 
                    render: (data) => data ? `${data}` : '-'
                },
                { 
                    data: 'id', 
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group d-flex gap-5">
                                <button class="btn btn-sm btn-warning edit-btn" data-id="${data}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">Hapus</button>
                            </div>`;
                    }
                }
            ],
            initComplete: function () {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });

        $('#tbl-university').on('click', '.edit-btn', function () {
            var id = $(this).data('id');
            showLoading();
            $.get(`/universities/${id}/edit`, function (university) {
                closeLoading();
                $('#edit_id').val(university.id);
                $('#edit_name').val(university.name);
                $('#edit_main_url').val(university.main_url);
                $('#edit_signin_url').val(university.signin_url);
                $('#edit_signout_url').val(university.signout_url);
                $('#batasan').val(university.batasan);
                $('#editUniversityForm').attr('action', '/universities/' + university.id);
                $('#editUniversityModal').modal('show');
                $('#editUniversityModal').on('shown.bs.modal', function () {
                    $('#editparent').val(String(university.parent));
                });
            });
        });

        $('#tbl-university').on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                        url: `/universities/${id}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (response) {
                            closeLoading();
                            if (response.status == 200) {
                                Swal.fire('Berhasil!', response.message, 'success');
                            } else {
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                            table.ajax.reload();
                        },
                        error: function () {
                            closeLoading();
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    });
                }
            });
        });

        $('#addUniversityForm').on('submit', function (e) {
            e.preventDefault();
            showLoading();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    closeLoading();
                    if (response.status == 200) {
                        Swal.fire('Berhasil!', response.message, 'success');
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                    $('#addUniversityModal').modal('hide');
                    $('#addUniversityForm').trigger('reset');
                    table.ajax.reload();
                },
                error: function () {
                    closeLoading();
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menambah data.', 'error');
                }
            });
        });


        $('#editUniversityForm').on('submit', function (e) {
            e.preventDefault();
            showLoading();
            $.ajax({
                url: $(this).attr('action'),
                type: 'PUT',
                data: $(this).serialize(),
                success: function (response) {
                    closeLoading();
                    if (response.status == 200) {
                        Swal.fire('Berhasil!', response.message, 'success');
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                    $('#editUniversityModal').modal('hide');
                    table.ajax.reload();
                },
                error: function () {
                    closeLoading();
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui data.', 'error');
                }
            });
        });

    });
</script>
@endpush

