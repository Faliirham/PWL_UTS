@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($employee)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr>
                <th>ID</th>
                <td>{{ $employee->id }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $employee->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $employee->email }}</td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td>{{ $employee->phone }}</td>
            </tr>
            <tr>
                <th>Posisi</th>
                <td>{{ $employee->position->name ?? 'Posisi Tidak Ditemukan' }}</td>
            </tr>
            <tr>
                <th>Cabang</th>
                <td>{{ $employee->branch->name ?? 'Cabang Tidak Ditemukan' }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>{{ $employee->hire_date }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($employee->status) }}</td>
            </tr>
        </table>
        @endempty
        <a href="{{ url('employee') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush
@push('js')
@endpush