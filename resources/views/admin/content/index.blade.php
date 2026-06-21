@extends('admin.layout.index')

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('message'))
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('message') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-success" id="btnShowModal">
                        Tambah Fitur
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Icon</th>
                                    <th>Title</th>
                                    <th>description</th>
                                    <th class="notexport">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['features'] as $feature)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $feature->icon }}</td>
                                        <td>{{ $feature->title }}</td>
                                        <td>{{ $feature->description }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning text-white rounded-3 px-3 shadow-sm"
                                                id="btnShowEditModal" data-id="{{ $feature->id }}"
                                                data-icon="{{ $feature->icon }}" data-title="{{ $feature->title }}"
                                                data-description="{{ $feature->description }}">
                                                Edit
                                            </button>
                                            |
                                            <form action="{{ route('content.destroyf', $feature->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this feature?')">
                                                    Delete
                                                </button>
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

    {{-- Price --}}
    <!-- <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-success" id="btnShowModalPrice">
                        Tambah Paket
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover datatable2">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 15%">Card Info</th>
                                    <th style="width: 25%">Package Title</th>
                                    <th style="width: 40%">Description & Features</th>
                                    <th class="notexport" style="width: 15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Proses perulangan data dari Controller (misal nama variabelnya $contents) --}}
                                @foreach ($data['content'] as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        <td>
                                            <span
                                                class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-2">
                                                Card {{ $item->card_number }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="fw-bold text-dark fs-6">{{ $item->title }}</div>
                                            <div class="text-success fw-semibold small mt-1">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="text-muted small mb-2">{{ $item->description }}</div>

                                            @if ($item->feature)
                                                <div class="pt-2 border-top border-light-subtle">
                                                    @foreach (explode('|', $item->feature) as $featureItem)
                                                        @if (trim($featureItem) != '')
                                                            <div class="small text-secondary mb-1">
                                                                <span class="text-success me-1">✓</span>
                                                                {{ trim($featureItem) }}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>

                                        <td class="notexport">
                                            <div class="d-flex flex-column gap-2">
                                                <div>
                                                    @if ($item->status == 'active')
                                                        <span
                                                            class="badge bg-success-subtle text-success border border-success-subtle rounded-2 px-2 py-1 small">Active</span>
                                                    @else
                                                        <span
                                                            class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-2 px-2 py-1 small">Inactive</span>
                                                    @endif
                                                </div>

                                                <button type="button"
                                                    class="btn btn-sm btn-warning text-white rounded-3 px-3 shadow-sm align-self-start"
                                                    id="btnShowEditModalPrice" data-id="{{ $item->id }}"
                                                    data-card_number="{{ $item->card_number }}"
                                                    data-title="{{ $item->title }}" data-price="{{ $item->price }}"
                                                    data-description="{{ $item->description }}"
                                                    data-feature="{{ $item->feature }}" data-status="{{ $item->status }}">
                                                    Edit
                                                </button>
                                                <form action="{{ route('content.destroyp', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger rounded-3 px-3 shadow-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    {{-- modal add --}}
    @include('admin.content.add_feature')
    {{-- @include('admin.content.add_price') --}}

    {{-- modal edit --}}
    @include('admin.content.edit_feature')
    {{-- @include('admin.content.edit_price') --}}
@endsection

@push('script')
    @include('admin.content.js')
@endpush
