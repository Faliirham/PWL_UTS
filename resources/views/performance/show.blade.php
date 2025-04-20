@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @empty($performance)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $performance->id }}</td>
                </tr>
                <tr>
                    <th>Karyawan</th>
                    <td>{{ $performance->employee->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Penilai</th>
                    <td>{{ $performance->evaluator->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nilai</th>
                    <td>{{ $performance->score }}</td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{{ $performance->notes }}</td>
                </tr>
                <tr>
                    <th>Tanggal Evaluasi</th>
                    <td>{{ $performance->evaluation_date }}</td>
                </tr>
                <tr>
                    <th>Dibuat</th>
                    <td>{{ $performance->created_at }}</td>
                </tr>
                <tr>
                    <th>Diubah Terakhir</th>
                    <td>{{ $performance->updated_at }}</td>
                </tr>
            </table>
        @endempty

        <a href="{{ url('performance') }}" class="btn btn-sm btn-default mt-3">Kembali</a>
    </div>
</div>
@endsection