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
                                <label for="user_id" class="form-label">Customer</label>
                                <select name="user_id" id="user_id" class="form-control form-control-sm" required>
                                    <option value=""></option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @selected($customer->id == ($record->user_id ?? ''))>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label for="subscribe_package_id" class="form-label">Package</label>
                                <select name="subscribe_package_id" id="subscribe_package_id" class="form-control form-control-sm" required>
                                    <option value=""></option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6 form-group">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control form-control-sm"  required>
                            </div>
                            <!-- <div class="col-12 col-sm-6 form-group">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" required>
                            </div> -->
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