@extends('admin.layout.index')

@section('content')
<style>
    .select2-selection__choice {
        color: #000 !important
    }
</style>
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
                <a href="{{ route('customer.create') }}" class="btn btn-sm btn-success">Tambah</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Reff. Code</th>
                                <th>Akun Id</th>
                                <th class="notexport">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                @php
                                    $akun_ids = ($record->akun_id != null) ? $record->akun_id : [];
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $record->name }}</td>
                                    <td>{{ $record->email }}</td>
                                    <td>{{ $record->referral_code }}</td>
                                    <td>{{ implode(', ' , $akun_ids) }}</td>
                                    <td>
                                        <form action="{{ route('customer.destroy', $record->id) }}" onsubmit="return confirm('Apakah anda yakin ?')" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-primary akunBtn" data-user="{{ $record->id }}">
                                                    Akun
                                                </button>
                                                <a href="{{ route('customer.show', $record->id) }}" class="btn btn-sm btn-info">
                                                    Detail
                                                </a>
                                                <a href="{{ route('customer.edit', $record->id) }}" class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>
                                            </div>
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
</div>

<div class="modal fade" id="akunModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Akun Id</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="" id="akunForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="akun">List Akun</label>
                        <select name="akun[]" id="akun" class="form-control form-control-sm" style="width: 100%" multiple required>
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-danger" id="clearBtn">Clear</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        var table = $('.datatable').DataTable({
            layout: {
                topStart: {
                    buttons: [
                        'pageLength',
                        {
                            extend: 'excel',
                            text: 'download',
                            title: 'Databaseriset - Data customer',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        }
                    ]
                }
            }
        })
        
        table.on('click', '.akunBtn' ,function(){
            userId = $(this).data('user')
            url = `customer/akun/${userId}`
            parent = $('#akun')

            $.get(url, function (akun_ids) {
                parent.empty()

                $.each(akun_ids, function(index, data){
                    
                    parent.append($('<option/>', {
                        value: data.akun_id,
                        text: `${data.akun_name} | ${data.akun_username}`,
                        selected: data.selected
                    }))
                })
            });

            parent.select2({
                dropdownParent: $('#akunModal'),
                multiple: true
            })
            $('#akunForm').attr('action', url)
            $('#akunModal').modal('show')
        })

        $('#clearBtn').click(function(){
            $('#akun').val(null).trigger('change')

            setTimeout(() => {
                $('#akunForm').submit()
            }, 120);
        })
    </script>
@endpush