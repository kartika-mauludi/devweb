@extends('admin.layout.index')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 form-group">
                            <label for="id_invoice" class="form-label">Id Invoice</label>
                            <input type="text" name="id_invoice" id="id_invoice" class="form-control form-control-sm" value="{{ $record->id_invoice ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="customer" class="form-label">Customer</label>
                            <input type="text" name="customer" id="customer" class="form-control form-control-sm" value="{{ $record->user->name ?? '' }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 form-group">
                            <label for="package" class="form-label">Package</label>
                            <input type="text" name="package" id="package" class="form-control form-control-sm" value="{{ $record->subscribeRecord->subscribePackage->name ?? '' }}" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" name="price" id="price" class="form-control form-control-sm" value="{{ $record->price ?? '' }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 form-group">
                            <label for="discount" class="form-label">Discount</label>
                            <input type="text" name="discount" id="discount" class="form-control form-control-sm" value="{{ $record->discount ?? 0 }} %" readonly>
                        </div>
                        <div class="col-12 col-sm-6 form-group">
                            <label for="grandtotal" class="form-label">Total</label>
                            <input type="text" name="grandtotal" id="grandtotal" class="form-control form-control-sm" value="{{ $record->grandtotal() ?? '' }}" readonly>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ $url }}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="{{ $prev }}" class="btn btn-sm btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection