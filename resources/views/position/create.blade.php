@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('position') }}">
            @csrf

            <div class="form-group">
                <label>Nama Jabatan</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ url('position') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection