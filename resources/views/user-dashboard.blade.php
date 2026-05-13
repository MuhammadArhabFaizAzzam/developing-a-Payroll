@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="mb-1">Dashboard Saya</h2>
                <p class="text-muted mb-0">Selamat datang, {{ $employee?->nama ?? $userName }}</p>
            </div>
            <div class="col-auto">
                @if(auth()->user()->desired_job)
                    <span class="badge bg-{{ auth()->user()->desired_job_status === 'diterima' ? 'success' : 'warning text-dark' }} px-3 py-2">
                        <i class="bi bi-{{ auth()->user()->desired_job_status === 'diterima' ? 'check-circle' : 'hourglass-split' }} me-1"></i>
                        {{ ucwords(str_replace('_', ' ', auth()->user()->desired_job_status ?? 'menunggu_review')) }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

@if(! $employee)
<div class="alert alert-warning">
    Akun ini belum ditautkan ke data karyawan. Hubungkan user ID atau email user ke data karyawan agar slip gaji pribadi muncul di sini.
</div>
@endif

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card blue h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1 text-white-50">Total Gaji Diterima</p>
                    <h3 class="mb-0">Rp {{ number_format($totalGaji, 0, ',', '.') }}</h3>
                </div>
                <i class="bi bi-wallet2 fs-1 opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card orange h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1 text-white-50">Slip Gaji Pending</p>
                    <h3 class="mb-0">{{ $pendingGaji }}</h3>
                </div>
                <i class="bi bi-clock-history fs-1 opacity-75"></i>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted small mb-1">Departemen Saat Ini</p>
                <h5 class="mb-0">{{ $employee?->departemen ?? '-' }}</h5>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <p class="text-muted small mb-1">Jabatan Saat Ini</p>
                <h5 class="mb-0">{{ $employee?->jabatan ?? '-' }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="bi bi-briefcase me-2 text-primary"></i>Pilih Pekerjaan</h5>
            </div>
            <div class="card-body">
                @if(auth()->user()->desired_job)
                    <div class="alert alert-{{ auth()->user()->desired_job_status === 'diterima' ? 'success' : 'info' }} mb-4">
                        {{ auth()->user()->desired_job_status === 'diterima' ? 'Pekerjaan disetujui:' : 'Pilihan terakhir:' }}
                        <strong>{{ auth()->user()->desired_job }}</strong>
                        di {{ auth()->user()->desired_department }}.
                    </div>
                @endif

                <form method="POST" action="{{ route('user.job-choice.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pekerjaan yang diminati</label>
                        <select name="job_choice" class="form-select @error('desired_job') is-invalid @enderror" required
                            onchange="
                                const selected = this.options[this.selectedIndex];
                                this.form.desired_department.value = selected.dataset.department || '';
                                this.form.desired_job.value = selected.dataset.job || '';
                            "
                        >
                            <option value="">Pilih departemen dan jabatan</option>
                            @foreach($jobOptions as $option)
                                <option
                                    value="{{ $option->departemen }} - {{ $option->jabatan }}"
                                    data-department="{{ $option->departemen }}"
                                    data-job="{{ $option->jabatan }}"
                                    {{ auth()->user()->desired_department === $option->departemen && auth()->user()->desired_job === $option->jabatan ? 'selected' : '' }}
                                >
                                    {{ $option->departemen }} - {{ $option->jabatan }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="desired_department" value="{{ old('desired_department', auth()->user()->desired_department) }}">
                        <input type="hidden" name="desired_job" value="{{ old('desired_job', auth()->user()->desired_job) }}">
                        @error('desired_department')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('desired_job')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send me-1"></i> Kirim ke Admin
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="bi bi-person-badge me-2 text-success"></i>Ringkasan Saya</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <div class="text-muted small">Nama</div>
                            <div class="fw-semibold">{{ $employee?->nama ?? $userName }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <div class="text-muted small">Email</div>
                            <div class="fw-semibold">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <div class="text-muted small">NIP</div>
                            <div class="fw-semibold">{{ $employee?->nip ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <div class="text-muted small">Status Karyawan</div>
                            <div class="fw-semibold">{{ $employee?->status ? ucfirst(str_replace('_', ' ', $employee->status)) : '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-transparent">
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
                        <th>Pengambilan</th>
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
                            @if($payroll->taken_at)
                                <span class="badge bg-success">
                                    Diambil {{ $payroll->taken_at->format('d M Y H:i') }}
                                </span>
                            @elseif($payroll->status === 'dibayar')
                                <span class="badge bg-info text-dark">Siap diambil</span>
                            @else
                                <span class="text-muted small">Menunggu admin</span>
                            @endif
                        </td>
                        <td class="d-flex gap-2">
                            @if($payroll->status === 'dibayar' && ! $payroll->taken_at)
                                <form method="POST" action="{{ route('user.payrolls.take', $payroll->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Ambil gaji periode ini?')">
                                        <i class="bi bi-wallet2"></i> Ambil Gaji
                                    </button>
                                </form>
                            @endif
                            @if($payroll->status === 'dibayar')
                                <a href="{{ route('user.payrolls.slip-gaji', $payroll->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="bi bi-printer"></i> Cetak
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
            <p class="text-muted mb-0">Belum ada riwayat slip gaji</p>
        </div>
        @endif
    </div>
</div>
@endsection
