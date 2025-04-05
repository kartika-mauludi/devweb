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

@push('script')
<script>
    $(document).ready(function () {
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
    });
</script>
@endpush