@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <h2 class="mb-1">Dashboard Saya</h2>
        <p class="text-muted mb-0">Selamat datang, {{ $employee?->nama ?? auth()->user()->name }}</p>
    </div>
</div>

@if(! $employee)
<div class="alert alert-warning">
    Akun ini belum ditautkan ke data karyawan. Hubungkan `user_id` atau email user ke data karyawan agar slip gaji pribadi muncul di sini.
</div>
@endif

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card stat-card blue">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="mb-1 text-white-50">Total Gaji Diterima</p>
                    <h3>Rp {{ number_format($totalGaji, 0, ',', '.') }}</h3>
                </div>
                <i class="bi bi-wallet2 fs-1 opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card stat-card orange">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="mb-1 text-white-50">Slip Gaji Pending</p>
                    <h3>{{ $pendingGaji }}</h3>
                </div>
                <i class="bi bi-clock-history fs-1 opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Riwayat Slip Gaji Saya</h5>
    </div>
    <div class="card-body">
        @if($payrolls->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Gaji Bersih</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payrolls as $payroll)
                    <tr>
                        <td>{{ $payroll->nama_bulan }}</td>
                        <td class="text-end fw-bold">Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge-status {{ $payroll->status }}">
                                {{ $payroll->status == 'dibayar' ? 'Lunas' : 'Pending' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('payrolls.slip-gaji', $payroll->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="bi bi-printer"></i> Cetak
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
            <p class="text-muted">Belum ada riwayat slip gaji</p>
        </div>
        @endif
    </div>
</div>
@endsection
