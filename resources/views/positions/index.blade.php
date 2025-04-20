@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('position/create') }}" class="btn btn-sm btn-primary mt-1">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-hover table-sm" id="table_position">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jabatan</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
    function modalAction(element) {
        let url = typeof element === "string" ? element : element.getAttribute("data-url");
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    var dataPosition;
    $(document).ready(function () {
        dataPosition = $('#table_position').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('position/list') }}",
                type: "POST",
                data: function (d) {
                    // Jika ada parameter lain yang perlu ditambahkan seperti filter, bisa ditambahkan di sini
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "name"
                },
                {
                    data: "description"
                },
                {
                    data: "aksi",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Jika ingin menambahkan event seperti filter atau lainnya, bisa ditambahkan di sini
        // $('#some_filter').on('change', function () {
        //     dataPosition.ajax.reload();
        // });
    });
</script>
@endpush