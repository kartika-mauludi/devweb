@extends('admin.layout.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ $url }}" method="post">
                        @csrf

                        <input type="hidden" name="Id" value="{{ $record->id ?? 0 }}" readonly>
        
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="environment" class="form-label">Environment</label>
                                <select name="environment" id="environment" class="form-control form-control-sm" required>
                                    <option value=""></option>
                                    <option @selected(($record->environment ?? '') == 'sandbox') value="sandbox">Sandbox</option>
                                    <option @selected(($record->environment ?? '') == 'production') value="production">Production</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="sandbox_client_key" class="form-label">Sandbox Client Key</label>
                                <input type="text" name="sandbox_client_key" id="sandbox_client_key" class="form-control form-control-sm" value="{{ $record->sandbox_client_key ?? '' }}" required>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="sandbox_server_key" class="form-label">Sandbox Server Key</label>
                                <input type="text" name="sandbox_server_key" id="sandbox_server_key" class="form-control form-control-sm" value="{{ $record->sandbox_server_key ?? '' }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="production_client_key" class="form-label">Production Client Key</label>
                                <input type="text" name="production_client_key" id="production_client_key" class="form-control form-control-sm" value="{{ $record->production_client_key ?? '' }}" required>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="production_server_key" class="form-label">Production Server Key</label>
                                <input type="text" name="production_server_key" id="production_server_key" class="form-control form-control-sm" value="{{ $record->production_server_key ?? '' }}" required>
                            </div>
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