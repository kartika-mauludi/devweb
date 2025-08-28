@extends('admin.layout.index')

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="font-weight-bold mb-0">Detail Universitas: {{ $university->name }}</h5>
                        <a href="/universities" class="btn btn-sm btn-warning">
                            <i class="fa fa-arrow-left fs-12"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 justify-content-between">
                        <p class="mb-0 font-weight-bold">Daftar Akun</p>
                        @if ($university->name == 'Universitas Airlangga' || $university->name == 'Arizona State University')
                        
                        @else
                            <div class="d-flex gap-5">
                                <button class="btn btn-sm btn-success" data-toggle="modal"
                                    data-target="#addAccountModal">Tambah</button>
                                <button class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#importAccountModal">Import</button>
                                <button class="btn btn-sm btn-danger" id="deleteBtn">Hapus All User</button>
                            </div>
                        @endif
                    </div>
                    @if ($university->name == 'Universitas Airlangga' || $university->name == 'Arizona State University')
                        <table id="tbl-university-account1" class="table table-sm table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="fit">#</th>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    @else
                        <table id="tbl-university-account" class="table table-sm table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="fit">#</th>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th class="fit text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    @endif
                    <hr>
                    <div class="d-flex align-items-center mb-2 justify-content-between">
                        <p class="mb-0 font-weight-bold">Daftar Website</p>
                        <div class="d-flex gap-5">
                            <button class="btn btn-sm btn-success" data-toggle="modal"
                                data-target="#addWebsiteModal">Tambah</button>
                            <button class="btn btn-sm btn-info" data-toggle="modal"
                                data-target="#importWebsiteModal">Import</button>
                        </div>
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

    @include('admin.universities.modal_account')
    @include('admin.universities.modal_website')
    @include('admin.universities.modal_import_account')
    @include('admin.universities.modal_import_website')
@endsection


@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        var universityId = "{{ $university->id }}";

        var accountTable = $('#tbl-university-account').DataTable({
            ordering: false,
            ajax: `/universities/${universityId}/accounts`,
            columns: [{
                    data: null,
                    render: (data, type, row, meta) => {
                        return `<div class="text-center">${meta.row + 1}.</div>`;
                    }
                },
                {
                    data: 'id'
                },
                {
                    data: 'username'
                },
                {
                    data: 'password'
                },
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
            initComplete: function() {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });

        var accountTable = $('#tbl-university-account1').DataTable({
            ordering: false,
            ajax: `/universities/${universityId}/accounts`,
            columns: [{
                    data: null,
                    render: (data, type, row, meta) => {
                        return `<div class="text-center">${meta.row + 1}.</div>`;
                    }
                },
                {
                    data: 'id'
                },
                {
                    data: 'username'
                },
                {
                    data: 'password'
                },
            ],
            initComplete: function() {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });

        var websiteTable = $('#tbl-university-website').DataTable({
            ordering: false,
            ajax: `/universities/${universityId}/websites`,
            columns: [{
                    data: null,
                    render: (data, type, row, meta) => {
                        return `<div class="text-center">${meta.row + 1}.</div>`;
                    }
                },
                // { data: 'university_id' },
                {
                    data: 'title'
                },
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
            initComplete: function() {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });

        $('#deleteBtn').on('click', function() {
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
                        url: `/universities/${universityId}/delete-all-accounts`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            closeLoading();
                            accountTable.ajax.reload();
                            Swal.fire('Sukses', res.success, 'success');
                        },
                        error: function() {
                            closeLoading();
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.',
                                'error');
                        }
                    });
                }
            });
        })
    </script>
@endpush
