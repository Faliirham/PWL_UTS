@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('employee/create') }}">Tambah</a>
                <button class="btn btn-sm btn-success mt-1" onclick="modalAction('{{ url('employee/create_ajax')}}')">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="branch_id" name="branch_id">
                                <option value="">- Semua Cabang - </option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Cabang Karyawan</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_employee">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Posisi</th>
                        <th>Cabang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" 
        role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true">
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

    var dataEmployee;
    $(document).ready(function () {
        dataEmployee = $('#table_employee').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('employee/list') }}",
                type: "POST",
                data: function (d) {
                    d.branch_id = $('#branch_id').val();
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                { data: "name" },
                { data: "email" },
                { data: "phone" },
                { data: "position", defaultContent: "-" },
                { data: "branch", defaultContent: "-" },
                { data: "status" },
                {
                    data: "aksi",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#branch_id').on('change', function () {
            dataEmployee.ajax.reload();
        });
    });
</script>
@endpush