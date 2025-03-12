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
                            <div class="col-12 col-sm-6 form-group">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control form-control-sm" value="{{ $record->amount ?? '' }}" step="any" required>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="type" class="form-label">Type</label>
                                <select name="type" id="type" class="form-control form-control-sm" required>
                                    <option value=""></option>
                                    <option @selected(($record->type ?? '') == 'percentage') value="percentage">Percentage</option>
                                    <option @selected(($record->type ?? '') == 'fixed') value="fixed">Fixed</option>
                                </select>
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