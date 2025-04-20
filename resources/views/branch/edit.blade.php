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
            <form method="POST" action="{{ url('branch/'.$branch->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nama Cabang</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $branch->name) }}" required>
                    @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="address" required>{{ old('address', $branch->address) }}</textarea>
                    @error('address')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Kota</label>
                    <input type="text" class="form-control" name="city" value="{{ old('city', $branch->city) }}" required>
                    @error('city')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $branch->phone) }}">
                    @error('phone')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('branch') }}" class="btn btn-secondary">Kembali</a>
            </form>
        @endif
    </div>
</div>
@endsection