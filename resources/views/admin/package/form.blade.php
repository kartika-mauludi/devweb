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
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ $record->name ?? '' }}" required>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" id="price" class="form-control form-control-sm" value="{{ $record->price ?? '' }}" step="any" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="discount" class="form-label">Discount</label>
                                <input type="number" name="discount" id="discount" class="form-control form-control-sm" value="{{ $record->discount ?? 0.00 }}" step="any" required>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="days" class="form-label">Days</label>
                                <input type="number" name="days" id="days" class="form-control form-control-sm" value="{{ $record->days ?? '' }}" required>
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