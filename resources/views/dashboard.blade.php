@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="mb-0">Dashboard</h2>
            </div>
            <div class="col-auto">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Stats Cards Premium -->
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card bg-gradient-primary text-white shadow-lg border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h2 mb-0 lh-1">{{ number_format($totalKaryawan) }}</div>
                        <div class="text-white-50 small">Total Karyawan</div>
                    </div>
                    <div class="card-icon">
                        <i class="bi bi-people fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card bg-gradient-success text-white shadow-lg border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h2 mb-0 lh-1">{{ number_format($karyawanAktif) }}</div>
                        <div class="text-white-50 small">Karyawan Aktif</div>
                    </div>
                    <div class="card-icon">
                        <i class="bi bi-person-check fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card bg-gradient-warning text-white shadow-lg border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h2 mb-0 lh-1">Rp {{ number_format($totalGajiBulanIni, 0, ',', '.') }}</div>
                        <div class="text-white-50 small">Gaji Bulan Ini</div>
                    </div>
                    <div class="card-icon">
                        <i class="bi bi-cash fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
        <div class="card bg-gradient-danger text-white shadow-lg border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="h2 mb-0 lh-1">{{ number_format($pilihanPekerjaanPending) }}</div>
                        <div class="text-white-50 small">Pilihan Pekerjaan</div>
                    </div>
                    <div class="card-icon">
                        <i class="bi bi-briefcase fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Actions -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100 shadow">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0"><i class="bi bi-grid-3x3-gap text-primary me-2"></i>Aksi Cepat</h5>
            </div>
            <div class="card-body pt-0">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('employees.create') }}" class="card h-100 border-0 text-decoration-none text-center p-4 bg-light rounded-3 hover-shadow transition-all">
                            <div class="icon-circle bg-primary bg-opacity-10 text-primary mb-3 mx-auto">
                                <i class="bi bi-person-plus fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">Tambah Karyawan</h6>
                            <p class="text-muted small mb-0">Kelola data karyawan baru</p>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('payrolls.create') }}" class="card h-100 border-0 text-decoration-none text-center p-4 bg-light rounded-3 hover-shadow transition-all">
                            <div class="icon-circle bg-success bg-opacity-10 text-success mb-3 mx-auto">
                                <i class="bi bi-cash-stack fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">Proses Gaji</h6>
                            <p class="text-muted small mb-0">Buat slip gaji bulan ini</p>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('employees.index') }}" class="card h-100 border-0 text-decoration-none text-center p-4 bg-light rounded-3 hover-shadow transition-all">
                            <div class="icon-circle bg-info bg-opacity-10 text-info mb-3 mx-auto">
                                <i class="bi bi-list-ul fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">Lihat Semua</h6>
                            <p class="text-muted small mb-0">Daftar karyawan lengkap</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100 shadow">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="card-title mb-0"><i class="bi bi-clock-history text-warning me-2"></i>Aktivitas Terbaru</h5>
            </div>
            <div class="card-body pt-0">
                <div class="list-group list-group-flush">
                    @forelse($penggajianTerbaru as $payroll)
                    <div class="list-group-item px-0 border-0 py-3">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar avatar-sm bg-{{ $payroll->status == 'dibayar' ? 'success' : 'warning' }} text-white rounded-circle">
                                    <i class="bi bi-{{ $payroll->status == 'dibayar' ? 'check-lg' : 'clock' }}"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-dark">{{ $payroll->employee->nama }}</div>
                                <div class="small text-muted">{{ $payroll->nama_bulan }}</div>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-{{ $payroll->status == 'dibayar' ? 'success' : 'warning' }}">
                                    {{ $payroll->status == 'dibayar' ? 'Lunas' : 'Pending' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-1 mb-3 opacity-50"></i>
                        <p class="mb-0">Belum ada aktivitas</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header bg-transparent">
        <h5 class="card-title mb-0"><i class="bi bi-briefcase text-primary me-2"></i>Pilihan Pekerjaan User</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama User</th>
                        <th>Email</th>
                        <th>Departemen Dipilih</th>
                        <th>Jabatan Dipilih</th>
                        <th>Status</th>
                        <th>Diperbarui</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pilihanPekerjaanTerbaru as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->desired_department }}</td>
                        <td>{{ $user->desired_job }}</td>
                        <td>
                            <span class="badge bg-{{ $user->desired_job_status === 'diterima' ? 'success' : 'warning text-dark' }}">
                                {{ ucwords(str_replace('_', ' ', $user->desired_job_status ?? 'menunggu_review')) }}
                            </span>
                        </td>
                        <td>{{ $user->updated_at?->format('d M Y H:i') }}</td>
                        <td>
                            @if($user->desired_job_status !== 'diterima')
                                <form method="POST" action="{{ route('admin.job-choices.approve', $user->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-check-circle me-1"></i> Terima
                                    </button>
                                </form>
                            @else
                                <span class="text-muted small">Sudah diterima</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox"></i><br>Belum ada pilihan pekerjaan dari user
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tables Section -->
<div class="row">
    <div class="col-xl-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 bg-transparent">
                <h6 class="mb-0 font-weight-bold text-primary"><i class="bi bi-people me-2"></i>Karyawan Terbaru</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($karyawanTerbaru as $employee)
                            <tr>
                                <td><span class="badge bg-light text-dark px-2 py-1 rounded-pill">{{ $employee->nip }}</span></td>
                                <td class="fw-semibold">{{ $employee->nama }}</td>
                                <td><span class="badge bg-{{ $employee->status == 'aktif' ? 'success' : 'secondary' }}">{{ $employee->departemen }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    <i class="bi bi-person-plus"></i><br>Belum ada karyawan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('employees.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-arrow-right"></i> Lihat Semua Karyawan
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 bg-transparent">
                <h6 class="mb-0 font-weight-bold text-success"><i class="bi bi-currency-exchange me-2"></i>Gaji per Departemen</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Departemen</th>
                                <th class="text-end">Total Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gajiPerDepartemen as $departemen => $total)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs me-2 bg-light">
                                            <i class="bi bi-briefcase text-primary"></i>
                                        </div>
                                        {{ $departemen }}
                                    </div>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-muted">
                                    <i class="bi bi-pie-chart"></i><br>Belum ada data
                                </td>
                            </tr>
                            @endforelse
                            @if(!empty($gajiPerDepartemen))
                            <tr class="table-primary">
                                <td class="fw-bold text-end">TOTAL</td>
                                <td class="text-end h5 mb-0 text-primary">Rp {{ number_format($totalGaji, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('payrolls.index') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-arrow-right"></i> Kelola Penggajian
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}
.bg-gradient-danger {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}
.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    transform: translateY(-2px);
}
.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
}
.avatar.avatar-sm { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; }
.avatar.avatar-xs { width: 24px; height: 24px; font-size: 0.625rem; }
.transition-all {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
@endsection

