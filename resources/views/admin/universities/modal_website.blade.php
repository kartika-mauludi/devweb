
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

<!-- Modal Edit Website -->
<div class="modal fade" id="editWebsiteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Website Universitas</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('universities.websites.store', $university->id) }}" method="PUT">
                @csrf
                <input type="hidden" name="_method">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="web-title-edit">Judul</label>
                        <input id="web-title-edit" type="text" name="title" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="web-url-edit">Link</label>
                        <input id="web-url-edit" type="url" name="url" class="form-control" required>
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

@push('script')
<script>
    $(document).ready(function () {
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
            console.log('AHAHAH');
            

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