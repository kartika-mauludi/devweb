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
                    <form action="{{ $url }}" method="post">
                        @csrf
                        @if (isset($record))
                            @method('PUT')
                        @endif
        
                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="amount" class="form-label">Besaran</label>
                                <input type="number" name="amount" id="amount" class="form-control form-control-sm" value="{{ $record->amount ?? '' }}" required placeholder="10000">
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="type" class="form-label">Type</label>
                                <select name="type" id="type" class="form-control form-control-sm" required>
                                    <option value="">pilih type</option>
                                    <option @selected(($record->type ?? '') == 'percentage') value="percentage">Persentase</option>
                                    <option @selected(($record->type ?? '') == 'fixed') value="fixed">Fixed</option>
                                </select>
                            </div>
                        </div>
                        @if(request('status'))
                          <input type="hidden" name="status" id="" value="{{ request('status') }}">
                        @endif
                    @if(request('status') != "global" && (!isset($record) || $record->status != "global") )
                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="users" class="form-label">User</label> <br>
                                <input type="checkbox" id="all"> <label for="all" style="font-weight: 500">Pilih Semua</label> 
                                <select name="users[]" id="users" class="form-control" style="width: 100%" multiple required>
                                    <option></option>
                                    @foreach ($users as $user)
                                        <option @if($collections) @selected(in_array($user->id, $collections))@endif value="{{ $user->id }}">{{ $user->name.' - '.$user->email.' - '.$user->nomor }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

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