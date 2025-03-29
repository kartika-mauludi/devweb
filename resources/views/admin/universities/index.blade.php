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
                            <th class="fit text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $index => $university)
                            <tr>
                                <td class="fit text-center">{{ $index + 1 }}.</td>
                                <td class="text-nowrap"><a href="/universities/{{ $university->id }}">{{ $university->name }}</a></td>
                                <td><a href="{{ $university->main_url }}" target="_blank">{{ $university->main_url }}</a></td>
                                <td><a href="{{ $university->signin_url }}" target="_blank">{{ $university->signin_url }}</a></td>
                                <td><a href="{{ $university->signout_url }}" target="_blank">{{ $university->signout_url }}</a></td>
                                <td class="fit text-center">
                                    <div class="btn-group d-flex gap-5">
                                        <button class="btn btn-sm btn-warning" onclick="editUniversity({{ $university }})" data-toggle="modal" data-target="#editUniversityModal">
                                            Edit
                                        </button>
                                        <form action="{{ route('universities.destroy', $university->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
            <form action="{{ route('universities.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Universitas</label>
                        <input type="text" name="name" class="form-control" required>
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
                        <input type="text" name="name" id="edit_name" class="form-control" required>
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
        $('#tbl-university').DataTable({
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
