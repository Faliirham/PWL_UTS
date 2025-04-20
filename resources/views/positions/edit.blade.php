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
            <form method="POST" action="{{ url('position/'.$position->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $position->name) }}" required>
                    @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea class="form-control" name="description">{{ old('description', $position->description) }}</textarea>
                    @error('description')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('position') }}" class="btn btn-secondary">Kembali</a>
            </form>
        @endif
    </div>
</div>
@endsection