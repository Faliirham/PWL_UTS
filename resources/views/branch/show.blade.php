@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @if (!$branch)
            <div class="alert alert-danger">Data tidak ditemukan.</div>
        @else
            <table class="table table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <td>{{ $branch->id }}</td>
                </tr>
                <tr>
                    <th>Nama Cabang</th>
                    <td>{{ $branch->name }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $branch->address }}</td>
                </tr>
                <tr>
                    <th>Kota</th>
                    <td>{{ $branch->city }}</td>
                </tr>
                <tr>
                    <th>Telepon</th>
                    <td>{{ $branch->phone }}</td>
                </tr>
            </table>
            <a href="{{ url('branch') }}" class="btn btn-secondary mt-2">Kembali</a>
        @endif
    </div>
</div>
@endsection