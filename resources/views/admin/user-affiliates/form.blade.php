@extends('admin.layout.index')

@section('content')
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
                                <label for="user_id" class="form-label">User Customer</label>
                                <select name="user_id" id="user_id" class="form-control form-control-sm" required>
                                    <option value=""></option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @selected($customer->id == ($record->user_id ?? 0))>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control form-control-sm" value="{{ $record->amount ?? '' }}" step="any" required>
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