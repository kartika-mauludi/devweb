@extends('admin.layout.index')

@section('content')
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center flex-column flex-column flex-md-row justify-content-md-between">
                    <h5 class="font-weight-bold mb-0">Detail Universitas: {{ $university->name }}</h5>
                    <a href="/universities" class="btn btn-sm btn-warning">
                        <i class="fa fa-arrow-left fs-12"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex align-items-center flex-column flex-md-row mb-2 justify-content-md-between">
                    <p class="mb-0 font-weight-bold">Daftar Akun</p>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addAccountModal">Tambah Akun</button>
                </div>
                <table id="tbl-university-account" class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="fit">No.</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th class="fit text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <hr>

                <div class="d-flex align-items-center flex-column flex-md-row mb-2 justify-content-md-between">
                    <p class="mb-0 font-weight-bold">Daftar Website</p>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addWebsiteModal">Tambah Website</button>
                </div>
                <table id="tbl-university-website" class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="fit text-center">No.</th>
                            <th>Judul</th>
                            <th>Link</th>
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

<!-- Modal Tambah Akun -->
<div class="modal fade" id="addAccountModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Akun Universitas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('universities.accounts.store', $university->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control" required>
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

<!-- Modal Tambah Website -->
<div class="modal fade" id="addWebsiteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Website Universitas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('universities.websites.store', $university->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="web-title">Judul</label>
                        <input id="web-title" type="text" name="title" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="web-url">Link</label>
                        <input id="web-url" type="url" name="url" class="form-control" required>
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

<!-- Modal Edit Akun -->
<div class="modal fade" id="editAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST">
            @csrf
            <input type="hidden" name="_method">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Akun</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Website -->
<div class="modal fade" id="editWebsiteModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST">
            @csrf
            <input type="hidden" name="_method">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Website</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="web-title=edit">Judul</label>
                        <input id="web-title=edit" type="text" name="title" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="web-url-edit">Link</label>
                        <input id="web-url-edit" type="url" name="url" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@push('script')
<script>
    $(document).ready(function () {
        let universityId = "{{ $university->id }}";

        let accountTable = $('#tbl-university-account').DataTable({
            responsive: true,
            ordering:false,
            ajax: `/universities/${universityId}/accounts`,
            columns: [
                { 
                    data: null, render: (data, type, row, meta) => {
                        return `<div class="text-center">${meta.row + 1}.</div>`;
                    } 
                },
                { data: 'username' },
                { data: 'password' },
                { 
                    data: 'id',
                    render: function(data) {
                        return `
                            <div class="btn-group d-flex gap-5">
                                <button class="btn btn-sm btn-warning edit-account" data-id="${data}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-account" data-id="${data}">Hapus</button>
                            </div>`;
                    }
                }
            ],
            initComplete: function () {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });

        let websiteTable = $('#tbl-university-website').DataTable({
            responsive: true,
            ordering:false,
            ajax: `/universities/${universityId}/websites`,
            columns: [
                { 
                    data: null, render: (data, type, row, meta) => {
                        return `<div class="text-center">${meta.row + 1}.</div>`;
                    } 
                },
                // { data: 'university_id' },
                { data: 'title' },
                { 
                    data: 'url',
                    render: (data) => data ? `<a href="${data}" target="_blank">${data}</a>` : '-' 
                },
                { 
                    data: 'id',
                    render: function(data) {
                        return `
                            <div class="btn-group d-flex gap-5">
                                <button class="btn btn-sm btn-warning edit-website" data-id="${data}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-website" data-id="${data}">Hapus</button>
                            </div>`;
                    }
                }
            ],
            initComplete: function () {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });


        $('#addAccountModal form, #editAccountModal form').submit(function (e) {
            e.preventDefault();
            showLoading();
            let form = $(this);
            let url = form.attr('action');
            let method = form.find('input[name="_method"]').val() || 'POST';

            $.ajax({
                url: url,
                type: method,
                data: form.serialize(),
                success: function (response) {
                    closeLoading();
                    if (response.status == 200) {
                        Swal.fire('Berhasil!', response.message, 'success');
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                    $('.modal').modal('hide');
                    form.trigger('reset');
                    accountTable.ajax.reload();
                },
                error: function () {
                    closeLoading();
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat memproses data.', 'error');
                }
            });
        });


        $('#tbl-university-account').on('click', '.edit-account', function () {
            let accountId = $(this).data('id');

            $.get(`/universities/${universityId}/accounts/${accountId}/edit`, function (data) {
                $('#editAccountModal input[name="username"]').val(data.username);
                $('#editAccountModal input[name="password"]').val(data.password);
                $('#editAccountModal form').attr('action', `/universities/${universityId}/accounts/${accountId}`);
                $('#editAccountModal input[name="_method"]').val('PUT');
                $('#editAccountModal').modal('show');
            });
        });

        $('#tbl-university-account').on('click', '.delete-account', function () {
            let accountId = $(this).data('id');

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                        url: `/universities/${universityId}/accounts/${accountId}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (res) {
                            closeLoading();
                            accountTable.ajax.reload();
                            Swal.fire('Sukses', res.success, 'success');
                        },
                        error: function () {
                            closeLoading();
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    });
                }
            });
        });


        $('#addWebsiteModal form, #editWebsiteModal form').submit(function (e) {
            e.preventDefault();
            showLoading();
            let form = $(this);
            let url = form.attr('action');
            let method = form.find('input[name="_method"]').val() || 'POST';

            $.ajax({
                url: url,
                type: method,
                data: form.serialize(),
                success: function (response) {
                    closeLoading();
                    if (response.status == 200) {
                        Swal.fire('Berhasil!', response.message, 'success');
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                    $('.modal').modal('hide');
                    form.trigger('reset');
                    websiteTable.ajax.reload();
                },
                error: function () {
                    closeLoading();
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat memproses data.', 'error');
                }
            });
        });


        $('#tbl-university-website').on('click', '.edit-website', function () {
            let websiteId = $(this).data('id');

            $.get(`/universities/${universityId}/websites/${websiteId}/edit`, function (data) {
                $('#editWebsiteModal input[name="title"]').val(data.title);
                $('#editWebsiteModal input[name="url"]').val(data.url);
                $('#editWebsiteModal form').attr('action', `/universities/${universityId}/websites/${websiteId}`);
                $('#editWebsiteModal input[name="_method"]').val('PUT');
                $('#editWebsiteModal').modal('show');
            });
        });

        $('#tbl-university-website').on('click', '.delete-website', function () {
            let websiteId = $(this).data('id');

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                        url: `/universities/${universityId}/websites/${websiteId}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (res) {
                            closeLoading();
                            websiteTable.ajax.reload();
                            Swal.fire('Sukses', res.success, 'success');
                        },
                        error: function () {
                            closeLoading();
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    });
                }
            });
        });

    });
</script>
@endpush
