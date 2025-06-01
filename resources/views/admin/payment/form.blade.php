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
                                <label for="id_invoice" class="form-label">Id Invoice</label>
                                <input type="text" name="id_invoice" id="id_invoice" class="form-control form-control-sm" value="{{ $record->id_invoice ?? '' }}" required>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="subscribe_record_id" class="form-label">Langganan Customer</label>
                                <select name="subscribe_record_id" id="subscribe_record_id" class="form-control form-control-sm" required>
                                    <option value=""></option>
                                    @foreach ($subscribeRecords as $subscribeRecord)
                                        <option value="{{ $subscribeRecord->id }}" @selected($subscribeRecord->id == ($record->subscribe_record_id ?? 0))>{{ ' - Paket ' . $subscribeRecord->subscribePackage->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" id="price" class="form-control form-control-sm" value="{{ $record->price ?? '' }}" required>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="discount" class="form-label">Discount</label>
                                <input type="number" name="discount" id="discount" class="form-control form-control-sm" value="{{ $record->discount ?? '' }}">
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