@extends('layouts.template')

@section('content')

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($user)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        <form method="POST" action="{{ url('/user/'.$user->id) }}" class="form-horizontal">
            @csrf
            @method('PUT')

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Nama</label>
                <div class="col-11">
                    <input type="text" class="form-control" name="name" 
                        value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Email</label>
                <div class="col-11">
                    <input type="email" class="form-control" name="email" 
                        value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Role</label>
                <div class="col-11">
                    <select class="form-control" name="role" required>
                        <option value="">- Pilih Role -</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="karyawan" {{ old('role', $user->role) == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    </select>
                    @error('role')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Cabang</label>
                <div class="col-11">
                    <select class="form-control" name="branch_id" required>
                        <option value="">- Pilih Cabang -</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Password</label>
                <div class="col-11">
                    <input type="password" class="form-control" name="password">
                    @error('password')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @else
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-11 offset-1">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a href="{{ url('user') }}" class="btn btn-sm btn-default ml-1">Kembali</a>
                </div>
            </div>
        </form>
        @endempty
    </div>
</div>

@endsection

@push('css')
@endpush

@push('js')
@endpush