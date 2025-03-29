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
                        @foreach ($university->accounts as $index => $account)
                            <tr>
                                <td class="fit text-center">{{ $index + 1 }}.</td>
                                <td>{{ $account->username }}</td>
                                <td>{{ $account->password }}</td>
                                <td class="fit">
                                    <form action="{{ route('universities.accounts.destroy', [$university->id, $account->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
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
                            <th>Website</th>
                            <th class="fit text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($university->websites as $index => $website)
                            <tr>
                                <td class="fit text-center">{{ $index + 1 }}.</td>
                                <td>{{ $website->website_id }}</td>
                                <td class="fit">
                                    <form action="{{ route('universities.websites.destroy', [$university->id, $website->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
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
                        <input type="text" name="username" class="form-control" required>
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
                        <label>Website ID</label>
                        <input type="number" name="website_id" class="form-control" required>
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
        $('#tbl-university-account').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: false,
            lengthMenu: [10, 25, 50, 100],
            initComplete: function () {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });
    });

    $(document).ready(function () {
        $('#tbl-university-website').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: false,
            lengthMenu: [10, 25, 50, 100],
            initComplete: function () {
                $(this).wrap('<div class="table-responsive"></div>');
            }
        });
    });

    function editUniversity(university) {
        $('#edit_id').val(university.id);
        $('#edit_name').val(university.name);
        $('#edit_main_url').val(university.main_url);
        $('#edit_signin_url').val(university.signin_url);
        $('#edit_signout_url').val(university.signout_url);

        $('#editUniversityForm').attr('action', '/universities/' + university.id);
    }
</script>
@endpush
