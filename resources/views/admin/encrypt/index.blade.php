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
                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#addAsuConfig">Tambah Arizona
                        Config</button>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addUnairConfig">Tambah Unair
                        Config</button>
                    <a onClick="return confirm('Apakah anda yakin ingin melakukan update agent?')"
                        href="{{ route('letencrypt.generate') }}"><button class="btn btn-sm btn-warning">Publish
                            Update</button></a>
                </div>

                <div class="p-3 table-responsive">
                    <table id="tbl-config" class="table table-sm table-bordered table-hover datatable w-100">
                        <thead>
                            <tr>
                                <th class="fit text-center">No.</th>
                                <th>Nama Universitas</th>
                                <th>Nama Config</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Address</th>
                                <th class="fit text-center notexport">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataConfig as $item)
                                <tr>
                                    <td class="fit text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->name_university }}</td>
                                    <td>{{ $item->name_config }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->password }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td class="fit text-center">
                                        <form action="{{ route('config.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin mau hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
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


    <div class="modal fade" id="addUnairConfig" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Config UNAIR</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('unair-addconfig') }}" method="POST" id="addUnairConfigForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Universitas</label>
                            <input type="text" name="name" value="Universitas Airlangga" class="form-control"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" placeholder="210.57.216.4">
                        </div>
                        <div class="form-group">
                            <label>File Config</label>
                            <input type="file" name="config" accept=".ovpn" class="form-control">
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

    <div class="modal fade" id="addAsuConfig" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Config Arizona</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('asu-addconfig') }}" method="POST" id="addAsuConfigForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Universitas</label>
                            <input type="text" name="name" value="Arizona State University" class="form-control"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label>Server</label>
                            <input type="text" name="name_config" class="form-control" placeholder="sslvpn.asu.edu">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
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
    </script>
@endpush
