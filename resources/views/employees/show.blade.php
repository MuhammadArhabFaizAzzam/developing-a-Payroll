@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Detail Karyawan</h2>
                <p class="text-muted mb-0">{{ $employee->nama }} - {{ $employee->nip }}</p>
            </div>
            <div>
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-person-circle text-secondary" style="font-size: 5rem;"></i>
                <h4 class="mt-3">{{ $employee->nama }}</h4>
                <p class="text-muted">{{ $employee->jabatan }}</p>
                <span class="badge-status {{ $employee->status }}">
                    {{ $employee->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Data Karyawan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="180"><strong>NIP</strong></td>
                        <td>: {{ $employee->nip }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>: {{ $employee->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Departemen</strong></td>
                        <td>: {{ $employee->departemen }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jabatan</strong></td>
                        <td>: {{ $employee->jabatan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Masuk</strong></td>
                        <td>: {{ $employee->tanggal_masuk->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Gaji Dasar</strong></td>
                        <td>: Rp {{ number_format($employee->gaji_dasar, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>No. HP</strong></td>
                        <td>: {{ $employee->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>: {{ $employee->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>No. Rekening</strong></td>
                        <td>: {{ $employee->no_rekening ?? '-' }} {{ $employee->nama_bank ? '(' . $employee->nama_bank . ')' : '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>NPWP</strong></td>
                        <td>: {{ $employee->npwp ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Riwayat Penggajian</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th class="text-end">Gaji Dasar</th>
                        <th class="text-end">Tunjangan</th>
                        <th class="text-end">Potongan</th>
                        <th class="text-end">Gaji Bersih</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penggajian as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->nama_bulan }}</td>
                        <td class="text-end">Rp {{ number_format($p->gaji_dasar, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($p->total_tunjangan, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($p->total_potongan, 0, ',', '.') }}</td>
                        <td class="text-end"><strong>Rp {{ number_format($p->gaji_bersih, 0, ',', '.') }}</strong></td>
                        <td>
                            <span class="badge-status {{ $p->status }}">
                                {{ $p->status == 'dibayar' ? 'Lunas' : 'Pending' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('payrolls.slip-gaji', $p->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="bi bi-file-earmark-text"></i> Slip
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                            <p class="mb-0">Belum ada riwayat penggajian</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
