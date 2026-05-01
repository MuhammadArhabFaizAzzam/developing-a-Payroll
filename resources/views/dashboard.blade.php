@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <h2 class="mb-1">Dashboard</h2>
        <p class="text-muted mb-0">Selamat datang di Sistem Penggajian Penerima Gaji</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card stat-card blue">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-white-50">Total Karyawan</p>
                    <h3 class="mb-0">{{ number_format($totalKaryawan) }}</h3>
                </div>
                <i class="bi bi-people"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card stat-card green">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-white-50">Karyawan Aktif</p>
                    <h3 class="mb-0">{{ number_format($karyawanAktif) }}</h3>
                </div>
                <i class="bi bi-person-check"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card stat-card orange">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-white-50">Total Gaji Bulan Ini</p>
                    <h3 class="mb-0">Rp {{ number_format($totalGajiBulanIni, 0, ',', '.') }}</h3>
                </div>
                <i class="bi bi-cash"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card stat-card red">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1 text-white-50">Pending Pembayaran</p>
                    <h3 class="mb-0">{{ number_format($penggajianPending) }}</h3>
                </div>
                <i class="bi bi-clock-history"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div class="row">
    <!-- Recent Employees -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Karyawan Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($karyawanTerbaru as $employee)
                            <tr>
                                <td>{{ $employee->nip }}</td>
                                <td>{{ $employee->nama }}</td>
                                <td>{{ $employee->departemen }}</td>
                                <td>{{ $employee->jabatan }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Belum ada data karyawan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
        </div>
    </div>

    <!-- Recent Payrolls -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Penggajian Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Periode</th>
                                <th>Gaji Bersih</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penggajianTerbaru as $payroll)
                            <tr>
                                <td>{{ $payroll->employee->nama }}</td>
                                <td>{{ $payroll->nama_bulan }}</td>
                                <td>Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge-status {{ $payroll->status }}">
                                        {{ $payroll->status == 'dibayar' ? 'Lunas' : 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Belum ada data penggajian</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <a href="{{ route('payrolls.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
        </div>
    </div>
</div>

<!-- Payroll by Department -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Gaji per Departemen</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Departemen</th>
                                <th class="text-end">Total Gaji Dibayar</th>
                                <th class="text-end">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gajiPerDepartemen as $departemen => $total)
                            <tr>
                                <td>{{ $departemen }}</td>
                                <td class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    {{ $totalGaji > 0 ? number_format(($total / $totalGaji) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Belum ada data</td>
                            </tr>
                            @endforelse
                            <tr class="table-secondary">
                                <th class="text-end">Total</th>
                                <th class="text-end">Rp {{ number_format($totalGaji, 0, ',', '.') }}</th>
                                <th class="text-end">100%</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .stat-card {
        padding: 20px;
        border-radius: 10px;
        color: #fff;
    }
</style>
@endsection
