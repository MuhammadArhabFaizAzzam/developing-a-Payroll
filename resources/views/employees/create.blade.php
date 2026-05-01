@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Tambah Karyawan Baru</h2>
                <p class="text-muted mb-0">Tambahkan data karyawan penerima gaji</p>
            </div>
            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('employees.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">NIP <span class="text-danger">*</span></label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" required>
                        @error('nip')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Departemen <span class="text-danger">*</span></label>
                        <select name="departemen" class="form-select" required>
                            <option value="">Pilih Departemen</option>
                            <option value="Keuangan" {{ old('departemen') == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                            <option value="HRD" {{ old('departemen') == 'HRD' ? 'selected' : '' }}>HRD</option>
                            <option value="IT" {{ old('departemen') == 'IT' ? 'selected' : '' }}>IT</option>
                            <option value="Marketing" {{ old('departemen') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="Operasional" {{ old('departemen') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                            <option value="Produksi" {{ old('departemen') == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                        </select>
                        @error('departemen')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
                        @error('jabatan')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                        @error('tanggal_masuk')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Gaji Dasar (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="gaji_dasar" class="form-control" value="{{ old('gaji_dasar', 5000000) }}" min="0" required>
                        @error('gaji_dasar')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">No. Rekening</label>
                <input type="text" name="no_rekening" class="form-control" value="{{ old('no_rekening') }}" placeholder="Contoh: 1234567890">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nama Bank</label>
                <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank') }}" placeholder="Contoh: Bank BRI">
            </div>
            
            <div class="mb-3">
                <label class="form-label">NPWP</label>
                <input type="text" name="npwp" class="form-control" value="{{ old('npwp') }}" placeholder="Contoh: 12.345.678.9-123.456">
            </div>
            
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Karyawan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
