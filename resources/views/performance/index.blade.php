@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('performance/create') }}">Tambah</a>
                <button class="btn btn-sm btn-success mt-1" onclick="modalAction('{{ url('performance/create_ajax') }}')">Tambah Ajax</button>
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
                        <label class="col-1 control-label col-form-label">Filter Cabang:</label>
                        <div class="col-3">
                            <select class="form-control" id="branch_id" name="branch_id">
                                <option value="">- Semua Cabang -</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Cabang Karyawan</small>
                        </div>
                    </div>
                </div>
            </div>            

            <table class="table table-bordered table-striped table-hover table-sm" id="table_performance">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Karyawan</th>
                        <th>Evaluator</th>
                        <th>Skor</th>
                        <th>Tanggal Evaluasi</th>
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
    var dataPerformance;
    $(document).ready(function () {
        dataPerformance = $('#table_performance').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('performance/list') }}",
                type: "POST",
                data: function (d) {
                    d.branch_id = $('#branch_id').val(); // Kirim branch_id ke server
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
                    data: "employee.name" // Menampilkan nama karyawan
                },
                {
                    data: "evaluator.name" // Menampilkan nama evaluator
                },
                {
                    data: "score"
                },
                {
                    data: "notes"
                },
                {
                    data: "aksi",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Memuat ulang data ketika filter cabang berubah
        $('#branch_id').on('change', function () {
            dataPerformance.ajax.reload();
        });
    });
</script>
@endpush