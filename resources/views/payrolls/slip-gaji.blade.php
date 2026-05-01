@extends('layouts.app')

@section('title', 'Slip Gaji')

@section('styles')
<style>
@media print {
    body { background: white; }
    .card { border: none; box-shadow: none; }
    .no-print { display: none; }
    .btn { display: none; }
}
</style>
@endsection

@section('content')
<div class="container py-4 no-print">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <button onclick="window.print()" class="btn btn-primary mb-3">
        <i class="bi bi-printer"></i> Cetak Slip Gaji
    </button>
</div>

<div class="card" id="slip-gaji">
    <div class="card-body p-4">
        <div class="text-center mb-4 border-bottom pb-3">
            <h4 class="mb-1">PENERIMA GAJI</h4>
            <p class="mb-0">Sistem Informasi Penggajian Karyawan</p>
            <h5 class="mt-3">SLIP GAJI</h5>
            <p class="mb-0">{{ $payroll->nama_bulan }}</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><td width="130"><strong>Nama Karyawan</strong></td><td>: {{ $payroll->employee->nama }}</td></tr>
                    <tr><td><strong>NIP</strong></td><td>: {{ $payroll->employee->nip }}</td></tr>
                    <tr><td><strong>Departemen</strong></td><td>: {{ $payroll->employee->departemen }}</td></tr>
                    <tr><td><strong>Jabatan</strong></td><td>: {{ $payroll->employee->jabatan }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><td width="130"><strong>Periode Gaji</strong></td><td>: {{ $payroll->nama_bulan }}</td></tr>
                    <tr><td><strong>Tanggal Bayar</strong></td><td>: {{ $payroll->tanggal_bayar ? $payroll->tanggal_bayar->format('d F Y') : 'Belum Dibayar' }}</td></tr>
                    <tr><td><strong>Status</strong></td><td>: <span class="badge-status {{ $payroll->status }}">{{ $payroll->status == 'dibayar' ? 'LUNAS' : 'PENDING' }}</span></td></tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold mb-3">PENGHASILAN</h6>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr><th>Keterangan</th><th class="text-end">Jumlah</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Gaji Pokok</td><td class="text-end">Rp {{ number_format($payroll->gaji_dasar, 0, ',', '.') }}</td></tr>
                        <tr><td>Tunjangan Transport</td><td class="text-end">Rp {{ number_format($payroll->tunjangan_transport, 0, ',', '.') }}</td></tr>
                        <tr><td>Tunjangan Makan</td><td class="text-end">Rp {{ number_format($payroll->tunjangan_makanan, 0, ',', '.') }}</td></tr>
                        <tr><td>Tunjangan Kesehatan</td><td class="text-end">Rp {{ number_format($payroll->tunjangan_kesehatan, 0, ',', '.') }}</td></tr>
                        <tr><td>Tunjangan Tahunan</td><td class="text-end">Rp {{ number_format($payroll->tunjangan_tahun, 0, ',', '.') }}</td></tr>
                        <tr class="table-success fw-bold"><td>Total Penghasilan</td><td class="text-end">Rp {{ number_format($payroll->gaji_dasar + $payroll->total_tunjangan, 0, ',', '.') }}</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <h6 class="fw-bold mb-3">POTONGAN</h6>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr><th>Keterangan</th><th class="text-end">Jumlah</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>BPJS (2%)</td><td class="text-end">Rp {{ number_format($payroll->potongan_bpjs, 0, ',', '.') }}</td></tr>
                        <tr><td>PPH (5%)</td><td class="text-end">Rp {{ number_format($payroll->potongan_pph, 0, ',', '.') }}</td></tr>
                        <tr><td>Potongan Alpha</td><td class="text-end">Rp {{ number_format($payroll->potongan_alpha, 0, ',', '.') }}</td></tr>
                        <tr><td>Potongan Lain</td><td class="text-end">Rp {{ number_format($payroll->potongan_lain, 0, ',', '.') }}</td></tr>
                        <tr class="table-danger fw-bold"><td>Total Potongan</td><td class="text-end">Rp {{ number_format($payroll->total_potongan, 0, ',', '.') }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-md-4 offset-md-8">
                <table class="table table-bordered table-lg">
                    <tr class="table-primary fw-bold">
                        <td>Gaji Bersih Diterima</td>
                        <td class="text-end fs-4">Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-md-4 text-center">
                <p class="mb-0">Penerima Gaji,</p>
                <br><br><br>
                <p class="mb-0 border-top pt-2">{{ $payroll->employee->nama }}</p>
            </div>
            <div class="col-md-4 text-center offset-md-4">
                <p class="mb-0">Hormat kami,</p>
                <br><br><br>
                <p class="mb-0 border-top pt-2">Bagian Keuangan</p>
            </div>
        </div>
    </div>
</div>
@endsection
