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
             <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addfileModal">Tambah</button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbl-file"class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Link</th>
                                <th>File Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah -->
<div class="modal fade" id="addfileModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah File</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('file.store') }}" method="POST" id="addfileForm">
                @csrf
                <div class="modal-body">
                <div class="form-group">
                        <label>Nama File</label>
                        <input type="text" name="name" id="name" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" id="type" class="form-control">
                             <option value="">-- Pilih Type --</option>
                             <option value="extension"> extension </option>
                             <option value="video"> video </option>
                        </select>
                    </div>
                    <div class="form-group urlinput" style="display: none">
                        <label>URL/Link</label>
                        <input type="url" name="link" id="url" class="form-control">
                    </div>
                    <div class="form-group fileinput" style="display: none">
                        <label>File</label>
                        <input type="file" name="file_location" id="file_location" class="form-control" accept="application/zip">
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
<div class="modal fade" id="editfileModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit File</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="editfileForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_id">
                    <div class="form-group">
                        <label>Nama File</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" id="edittype" class="form-control">
                             <option value="">-- Pilih Type --</option>
                             <option value="extension"> extension </option>
                             <option value="video"> video </option>
                        </select>
                    </div>
                    <div class="form-group urlinput" style="display: none">
                        <label>URL/Link</label>
                        <input type="url" name="link" id="edit_url" class="form-control">
                    </div>
                    <div class="form-group fileinput" style="display: none">
                        <label>File</label>
                        <input type="file" name="file_location" id="edit_file_location" class="form-control" accept="application/zip">
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
        var table = $('#tbl-file').DataTable({
            processing: true,
            ordering: false,
            serverSide: false,
            ajax: "{{ route('file.data') }}",
            columns: [
                { 
                    data: null, render: (data, type, row, meta) => {
                        return `<div class="text-center">${meta.row + 1}.</div>`;
                    } 
                },
                { 
                    data: 'name', 
                    render: (data, type, row) => `${data}`
                },
                { 
                    data: 'type', 
                    render: (data) => data ? `${data}` : '-'
                },
                { 
                    data: 'link', 
                    render: (data) => data ? `${data}` : '-'
                },
                {
                    data: 'file_location',
                    render: (data, type, row) => data ? `<a href="{{ url('/storage') }}/${data}" target="_blank" download>${data}</a>` : '-'
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
        $('#tbl-file').on('click', '.edit-btn', function () {
            var id = $(this).data('id');
            showLoading();
            var url = "{{ route('file.edit', ':id') }}".replace(':id', id);
            $.get(url, function (file) {
                closeLoading();
                $('#edit_id').val(file.id);
                $('#edit_name').val(file.name);
                $('#edit_url').val(file.link);
                var updateUrl = "{{ route('file.update', ':id') }}".replace(':id', file.id);
                $('#editfileForm').attr('action', updateUrl);
                $('#editfileModal').modal('show');
                $('#editfileModal').on('shown.bs.modal', function () {
                    $('#edittype').val(String(file.type)).change();
                });
            });
        });

        $('#tbl-file').on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            var url = "{{ route('file.destroy', ':id') }}".replace(':id', id);
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
                        url: url,
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

        $('#addfileForm').on('submit', function (e) {
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
                        Swal.fire('Berhasil!', response.message, 'success');
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                    $('#addfileModal').modal('hide');
                    $('#addfileForm').trigger('reset');
                    table.ajax.reload();
                },
                error: function () {
                    closeLoading();
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menambah data.', 'error');
                }
            });
        });

        $('#editfileForm').on('submit', function (e) {
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
                        Swal.fire('Berhasil!', response.message, 'success');
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                    $('#editfileModal').modal('hide');
                    table.ajax.reload();
                },
                error: function () {
                    closeLoading();
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui data.', 'error');
                }
            });
        });

        $('select[name="type"]').on('change', function (e) {
            const val = $(this).val()

            if (val == 'extension') {
                $('.fileinput').show()
                $('.urlinput').hide()
            } else {
                $('.fileinput').hide()
                $('.urlinput').show()
            }
        })
    });
</script>
@endpush
