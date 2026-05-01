@extends('layouts.app')

@section('title', 'Proses Penggajian')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Proses Penggajian</h2>
                <p class="text-muted mb-0">Buat slip gaji untuk karyawan</p>
            </div>
            <a href="{{ route('payrolls.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Pilih Karyawan</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('payrolls.proses') }}">
            @csrf
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Bulan <span class="text-danger">*</span></label>
                    <select name="bulan" class="form-select" required>
                        @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][$i] }}
                        </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tahun <span class="text-danger">*</span></label>
                    <select name="tahun" class="form-select" required>
                        @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            
            @if($employees->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th class="text-end">Gaji Dasar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>
                                <input type="checkbox" name="employee_id[]" value="{{ $employee->id }}">
                            </td>
                            <td>{{ $employee->nip }}</td>
                            <td>{{ $employee->nama }}</td>
                            <td>{{ $employee->departemen }}</td>
                            <td>{{ $employee->jabatan }}</td>
                            <td class="text-end">Rp {{ number_format($employee->gaji_dasar, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <hr>
            <div class="d-flex justify-content-between">
                <div>
                    <input type="checkbox" id="checkAllBottom"> Pilih Semua
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Proses Penggajian
                </button>
            </div>
            @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-check-circle" style="font-size: 3rem;"></i>
                <p class="mt-3">Semua karyawan sudah memiliki slip gaji untuk periode ini</p>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Info Perhitungan</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold">Tunjangan:</h6>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check text-success"></i> Tunjangan Transport: Rp 500.000</li>
                    <li><i class="bi bi-check text-success"></i> Tunjangan Makan: Rp 300.000</li>
                    <li><i class="bi bi-check text-success"></i> Tunjangan Kesehatan: Rp 200.000</li>
                    <li><i class="bi bi-check text-success"></i> Tunjangan Tahunan: 5% dari gaji dasar</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold">Potongan:</h6>
                <ul class="list-unstyled">
                    <li><i class="bi bi-x text-danger"></i> BPJS: 2% dari gaji dasar</li>
                    <li><i class="bi bi-x text-danger"></i> PPH: 5% dari (gaji + tunjangan)</li>
                    <li><i class="bi bi-x text-danger"></i> Potongan alpha: sesuai kehadiran</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const checkAll = document.getElementById('checkAll');
const checkAllBottom = document.getElementById('checkAllBottom');

checkAll?.addEventListener('change', function() {
    document.querySelectorAll('input[name="employee_id[]"]').forEach(function(cb) {
        cb.checked = checkAll.checked;
    });
});

checkAllBottom?.addEventListener('change', function() {
    document.querySelectorAll('input[name="employee_id[]"]').forEach(function(cb) {
        cb.checked = checkAllBottom.checked;
    });
});
</script>
@endsection
