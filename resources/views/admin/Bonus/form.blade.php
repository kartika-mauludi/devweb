@extends('admin.layout.index')

@section('content')
<style>
    .select2-selection__choice {
        color: #000 !important
    }
</style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ $url }}" method="post" enctype='multipart/form-data'>
                        @csrf
                        @if (isset($bonus))
                            @method('PUT')
                        @endif
    
                        <div class="modal-body">
                            <input type="hidden" id="edit_id_bonus" value="" class="edit_id_bonus">
                            <div class="form-group">
                                <label>Nama File</label>
                                <input type="text" name="name" id="edit_name_bonus" class="form-control edit_name_bonus" value="{{ $bonus->name  }}" required autofocus>
                            </div>
                           
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="edit_username_bonus" class="form-control" value="{{ $bonus->username }}" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" name="password" id="edit_password_bonus" class="form-control" value="{{ $bonus->password }}" required autofocus>
                            </div>
                            <div class="form-group fileinput">
                                <label>File</label>
                                <input type="file" name="file_location" id="edit_file_location_bonus" class="form-control edit_file_location" accept="application/zip/jpeg/jpg/png">
                            </div>
                            @if($bonus->type === "private")
                            <div class="form-group">
                                <label for="users" class="form-label">Customer</label> <br>
                                    <input type="checkbox" id="all" class="all"> <label for="all" style="font-weight: 500">Pilih Semua</label> 
                                    <select name="users[]" id="users" class="form-control" style="width: 100%" multiple required>
                                    <option></option>
                                    @foreach ($users as $user)
                                        <option @if($collections) @selected(in_array($user->id, $collections))@endif value="{{ $user->id }}">{{ $user->name.' - '.$user->email.' - '.$user->nomor }}</option>
                                    @endforeach
                                </select>
                             </div>
                            @endif
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-sm btn-success">{{ $label }}</button>
                                <a href="{{ $prev }}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $('#users').select2({
        multiple: true,
        placeholder: 'Pilih Customer'
    })

    $('#all').on('change', function(){

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