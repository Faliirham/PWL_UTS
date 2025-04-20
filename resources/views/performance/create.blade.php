@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ url('performance') }}" method="POST">
            @csrf

            <div class="form-group row">
                <label class="col-2 col-form-label">Karyawan</label>
                <div class="col-10">
                    <select name="employee_id" class="form-control" required>
                        <option value="">- Pilih Karyawan -</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">Penilai</label>
                <div class="col-10">
                    <select name="evaluator_id" class="form-control" required>
                        <option value="">- Pilih Penilai -</option>
                        @foreach($evaluators as $evaluator)
                            <option value="{{ $evaluator->id }}" {{ old('evaluator_id') == $evaluator->id ? 'selected' : '' }}>
                                {{ $evaluator->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('evaluator_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">Nilai</label>
                <div class="col-10">
                    <input type="number" step="0.01" name="score" class="form-control" value="{{ old('score') }}" required>
                    @error('score')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">Catatan</label>
                <div class="col-10">
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">Tanggal Evaluasi</label>
                <div class="col-10">
                    <input type="date" name="evaluation_date" class="form-control" value="{{ old('evaluation_date') }}" required>
                    @error('evaluation_date')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-10 offset-2">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a href="{{ url('performance') }}" class="btn btn-sm btn-default">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection