@extends('layouts.app')

@section('title', 'Daftar Penggajian')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Daftar Penggajian</h2>
                <p class="text-muted mb-0">Kelola proses penggajian karyawan</p>
            </div>
            <a href="{{ route('payrolls.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Proses Penggajian
            </a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Bulan</label>
                <select name="bulan" class="form-select">
                    @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$i] }}
                    </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tahun</label>
                <select name="tahun" class="form-select">
                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="dibayar" {{ $status == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('payrolls.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="mb-1">Total Gaji Bersih</h6>
                <h4 class="mb-0">Rp {{ number_format($totalGaji, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="mb-1">Total Tunjangan</h6>
                <h4 class="mb-0">Rp {{ number_format($totalTunjangan, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6 class="mb-1">Total Potongan</h6>
                <h4 class="mb-0">Rp {{ number_format($totalPotongan, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('payrolls.lunaskan-batch') }}">
            @csrf
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>No</th>
                            <th>Karyawan</th>
                            <th>Departemen</th>
                            <th>Periode</th>
                            <th class="text-end">Gaji Dasar</th>
                            <th class="text-end">Tunjangan</th>
                            <th class="text-end">Potongan</th>
                            <th class="text-end">Gaji Bersih</th>
                            <th>Status</th>
                            <th>Pengambilan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls as $no => $p)
                        <tr>
                            <td>
                                @if($p->status == 'pending')
                                <input type="checkbox" name="payroll_ids[]" value="{{ $p->id }}">
                                @endif
                            </td>
                            <td>{{ $no + $payrolls->firstItem() }}</td>
                            <td>
                                <a href="{{ route('employees.show', $p->employee->id) }}" class="text-primary fw-bold">
                                    {{ $p->employee->nama }}
                                </a>
                                <br>
                                <small class="text-muted">{{ $p->employee->nip }}</small>
                            </td>
                            <td>{{ $p->employee->departemen }}</td>
                            <td>{{ $p->nama_bulan }}</td>
                            <td class="text-end">Rp {{ number_format($p->gaji_dasar, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($p->total_tunjangan, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($p->total_potongan, 0, ',', '.') }}</td>
                            <td class="text-end">
                                <strong>Rp {{ number_format($p->gaji_bersih, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                <span class="badge-status {{ $p->status }}">
                                    {{ $p->status == 'dibayar' ? 'Lunas' : 'Pending' }}
                                </span>
                            </td>
                            <td>
                                @if($p->taken_at)
                                    <span class="badge bg-success">Diambil</span>
                                    <br>
                                    <small class="text-muted">{{ $p->taken_at->format('d M Y H:i') }}</small>
                                @elseif($p->status === 'dibayar')
                                    <span class="badge bg-info text-dark">Belum diambil</span>
                                @else
                                    <span class="text-muted small">Belum dibayar</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('payrolls.slip-gaji', $p->id) }}" class="btn btn-sm btn-outline-primary" target="_blank" title="Cetak Slip">
                                    <i class="bi bi-file-earmark-text"></i>
                                </a>
                                @if($p->status == 'pending')
                                <form method="POST" action="{{ route('payrolls.lunaskan', $p->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Lunasi" onclick="return confirm('Yakin lunasi?')">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0">Belum ada data penggajian</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($payrolls->count() > 0)
            <div class="card-footer bg-white">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Lunasi Terpilih
                </button>
            </div>
            @endif
        </form>
        
        @if($payrolls->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $payrolls->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('checkAll').addEventListener('change', function() {
    document.querySelectorAll('input[name="payroll_ids[]"]').forEach(function(cb) {
        cb.checked = document.getElementById('checkAll').checked;
    });
});
</script>
@endsection
