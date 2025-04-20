@extends('layouts.template')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid">
    <!-- Header Selamat Datang -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 bg-gradient-success text-white rounded shadow-sm">
                <h2 class="mb-0">Selamat Datang di <strong>PerfomaCafé</strong></h2>
                <p class="mb-0">Sistem Pemantauan Kinerja Karyawan Multi-Cabang</p>
            </div>
        </div>
    </div>

    <!-- Fitur Aplikasi -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-primary text-white h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-store"></i> Branch</h5>
                    <p class="card-text">Kelola data cabang café seperti nama cabang, lokasi, dan status operasional.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-info text-white h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-briefcase"></i> Position</h5>
                    <p class="card-text">Atur posisi atau jabatan dalam organisasi seperti Barista, Manager, dan lainnya.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-warning text-white h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Employee</h5>
                    <p class="card-text">Kelola data karyawan mulai dari identitas, posisi, hingga penempatan cabang.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow border-0 bg-success text-white h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-chart-line"></i> Performances</h5>
                    <p class="card-text">Pantau dan nilai kinerja karyawan berdasarkan indikator dan periode kerja tertentu.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow border-0 bg-danger text-white h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-cog"></i> User</h5>
                    <p class="card-text">Kelola akun pengguna sistem dengan hak akses sesuai peran (Admin, HR, dll).</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection