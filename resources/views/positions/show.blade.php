@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @if (!$position)
            <div class="alert alert-danger">Data tidak ditemukan.</div>
        @else
            <table class="table table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <td>{{ $position->id }}</td>
                </tr>
                <tr>
                    <th>Nama Jabatan</th>
                    <td>{{ $position->name }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $position->description }}</td>
                </tr>
            </table>
            <a href="{{ url('position') }}" class="btn btn-secondary mt-2">Kembali</a>
        @endif
    </div>
</div>
@endsection