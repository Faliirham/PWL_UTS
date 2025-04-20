@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('branch/create') }}" class="btn btn-sm btn-primary mt-1">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Filter Kota</label>
                <select id="filter_city" class="form-control">
                    <option value="">Semua Kota</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city }}">{{ $city }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <table class="table table-bordered table-hover table-sm" id="table_branch">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Cabang</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
    var dataBranch;
    $(document).ready(function () {
        dataBranch = $('#table_branch').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('branch/list') }}",
                type: "POST",
                data: function (d) {
                    d.city = $('#filter_city').val(); // kirim data filter kota
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "name" },
                { data: "address" },
                { data: "city" },
                { data: "phone" },
                { data: "aksi", orderable: false, searchable: false }
            ]
        });

        $('#filter_city').on('change', function () {
            dataBranch.ajax.reload();
        });
    });
</script>
@endpush