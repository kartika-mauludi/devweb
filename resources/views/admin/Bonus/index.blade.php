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

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('error') }}
            </div>
        @endsession
     
        <h4> Master Bonus Global </h2>
        <div class="card">
            <div class="card-header">
                <div id="bonus-data" data-count=""></div>
                <div id="btn-bonus-data"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbl-bonus-global"class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Bonus Global-->
        <div class="modal fade" id="addbonusmodalglobal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Bonus Global</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('bonus.store-bonus') }}" method="POST" class="addfileForm" id="tbl-bonus-global">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama File</label>
                                <input type="text" name="name" id="name" class="form-control" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="username" class="form-control" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" name="password" id="password" class="form-control" required autofocus>
                            </div>
                            <div class="form-group fileinput">
                                <label>File</label>
                                <input type="file" name="file_location" id="file_location" class="form-control" accept="application/zip">
                                <span class="text-muted">Maksimal 5MB</span>
                            </div>
                        </div>
                        <input type="hidden" name="type" id="type" class="form-control" value="global" autofocus>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <h4> Master Bonus Personal </h2>
        <div class="card">
            <div class="card-header">
             <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addBonusModal">Tambah</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tbl-bonus-private"class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Bonus-->
        <div class="modal fade" id="addBonusModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Bonus Private</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('bonus.store-bonus') }}" method="POST" class="addfileForm" id="tbl-bonus-private" enctype='multipart/form-data'>
                        @csrf
                        <div class="modal-body">
                        <input type="hidden" name="type" id="type" class="form-control" value="private" autofocus>
                            <div class="form-group">
                                <label>Nama File</label>
                                <input type="text" name="name" id="name" class="form-control" required autofocus>
                            </div>
                            <div class="form-group">
                            <label for="users" class="form-label">Customer</label> <br>
                                <input type="checkbox" id="all" class="all"> <label for="all" style="font-weight: 500">Pilih Semua</label> 
                                <select name="users[]" id="users"  class="form-control customers_bonus" style="width: 100%" multiple required>
                                    <option></option>
                                    @foreach ($users as $user)
                                        <option @if($collections) @selected(in_array($user->id, $collections))@endif value="{{ $user->id }}">{{ $user->name.' - '.$user->email.' - '.$user->nomor }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="username" class="form-control" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" name="password" id="password" class="form-control" required autofocus>
                            </div>
                            <div class="form-group fileinput">
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
@endsection

@push('script')
<script>
    $(document).ready(function () {
        var table = $('#tbl-bonus-global').DataTable({
            processing: true,
            ordering: false,
            serverSide: false,
            ajax: "{{ route('bonus.data-bonus-global') }}",
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
                    data: 'username', 
                    render: (data) => data ? `${data}` : '-'
                },
                { 
                    data: 'password', 
                    render: (data) => data ? `${data}` : '-'
                },
                {
                    data: 'file_location',
                    render: (data, type, row) => data ? `<a href="{{ asset('/storage') }}/${data}" target="_blank" download>${data}</a>` : '-'
                },
                { 
                    data: 'id', 
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group d-flex gap-5">
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">Hapus</button>
                            </div>`;
                    }
                }
            ],
            initComplete: function () {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });

        $('#tbl-bonus-global').on('click', '.delete-btn', function () {
            var table = $('.table').DataTable();
            var id = $(this).data('id');
            var url = "{{ route('bonus.destroy-bonus', ':id') }}".replace(':id', id);
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

        var table = $('#tbl-bonus-private').DataTable({
            processing: true,
            ordering: false,
            serverSide: false,
            ajax: "{{ route('bonus.data-bonus') }}",
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
                    data: 'username', 
                    render: (data) => data ? `${data}` : '-'
                },
                { 
                    data: 'password', 
                    render: (data) => data ? `${data}` : '-'
                },
                {
                    data: 'file_location',
                    render: (data, type, row) => data ? `<a href="{{ asset('/storage') }}/${data}" target="_blank" download>${data}</a>` : '-'
                },
                { 
                    data: 'id', 
                    render: function(data, type, row) {
                        const editBonusUrl = `{{ route('bonus.edit-bonus', ':id') }}`.replace(':id', data);
                        const detailBonusUrl = `{{ route('bonus.show-bonus', ':id') }}`.replace(':id', data);
                        return `
                            <div class="btn-group d-flex gap-5">
                                <a href="${detailBonusUrl}" class="btn btn-sm btn-primary"> Detail </a>
                                <a href="${editBonusUrl}" class="btn btn-sm btn-warning"> Edit </a>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">Hapus</button>
                            </div>`;
                    }
                },
              
            ],
            initComplete: function () {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });
        
        $('#tbl-bonus-private').on('click', '.edit-btn', function () {
            var table = $('.table').DataTable();
            var id = $(this).data('id');
            showLoading();
            var url = "{{ route('bonus.edit-bonus', ':id') }}".replace(':id', id);
          
            $.get(url, function (file) {
                closeLoading();
                $('#edit_id_bonus').val(file.file.id);
                $('#edit_name_bonus').val(file.file.name);
                $('#edit_username_bonus').val(file.file.username);
                $('#edit_password_bonus').val(file.file.password);

                var updateUrl = "{{ route('bonus.update-bonus', ':id') }}".replace(':id', file.file.id);
                $('#editfileFormbonus').attr('action', updateUrl);

                // Set value sebelum show modal
                if (Array.isArray(file.customer)) {
                    const customerIds = file.customer.map(String);
                    $('#customer_bonus').val(customerIds).trigger('change');
                }

                $('#editBonusModal').modal('show');
            });
        });

        $(document).on('click', '.delete-btn', function () {
            var table = $('.table').DataTable();
            var id = $(this).data('id');
            var url = "{{ route('bonus.destroy-bonus', ':id') }}".replace(':id', id);
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
                            $.get("{{ route('bonus.count') }}", function (data) {
                                const bonusData = document.getElementById("bonus-data");
                                bonusData.dataset.count = data.count;
                                renderBonusButton(data.count);
                            });
                          
                        },
                        error: function () {
                            closeLoading();
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    });
                }
            });
        });

        $(document).on('submit','.addfileForm', function (e) {
            var table = $('.table').DataTable();
            e.preventDefault();
            showLoading();
            var form = this;
            var formData = new FormData($(this)[0]);
            var table = $('.table').DataTable();

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
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
                    $(form).closest('.modal').modal('hide');
                    form.reset();
                    table.ajax.reload();
                    $.get("{{ route('bonus.count') }}", function (data) {
                                const bonusData = document.getElementById("bonus-data");
                                bonusData.dataset.count = data.count;
                                renderBonusButton(data.count);
                            });

                },
                error: function () {
                    closeLoading();
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menambah data.', 'error');
                }
            });
        });

        $('.editfileForm').on('submit', function (e) {
            var table = $('.table').DataTable();
            e.preventDefault();
            showLoading();
            var form = this;
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
                    $(form).closest('.modal').modal('hide');
                    form.reset();
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

<script>
 function renderBonusButton(count, id) {
  const buttonContainer = document.getElementById("btn-bonus-data");
  if (!buttonContainer) return;
  var url = "{{ route('bonus.edit-bonus', ':id') }}".replace(':id', id);
  if (count >= 1) {
    buttonContainer.innerHTML = `
          <a href="${url}" class="btn btn-sm btn-warning"> Edit Bonus Global </a>
    `;
  } else {
    buttonContainer.innerHTML = `
      <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addbonusmodalglobal">Tambah</button>
    `;
  }
}

document.addEventListener("DOMContentLoaded", function () {
    fetch("{{ route('bonus.count') }}")
    .then(res => res.json())
    .then(data => {
      renderBonusButton(data.count, data.id_global);
    });

});

$('.customers_bonus').select2({
        multiple: true,
        placeholder: 'Pilih Customer',
    })

    $('.all').on('change', function(){
        
        if ($(this).is(':checked')) {
            $('#users > option').attr('selected', true)
            $('#users').trigger('change')
        } else {
            $('#users > option').attr('selected', false)
            $('#users').trigger('change')
        }
    })

</script>

@endpush
