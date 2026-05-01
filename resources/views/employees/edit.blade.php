@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Edit Karyawan</h2>
                <p class="text-muted mb-0">Edit data {{ $employee->nama }}</p>
            </div>
            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('employees.update', $employee->id) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">NIP <span class="text-danger">*</span></label>
                        <input type="text" name="nip" class="form-control" value="{{ $employee->nip }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ $employee->nama }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $employee->email }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ $employee->no_hp }}">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Departemen <span class="text-danger">*</span></label>
                        <select name="departemen" class="form-select" required>
                            <option value="Keuangan" {{ $employee->departemen == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                            <option value="HRD" {{ $employee->departemen == 'HRD' ? 'selected' : '' }}>HRD</option>
                            <option value="IT" {{ $employee->departemen == 'IT' ? 'selected' : '' }}>IT</option>
                            <option value="Marketing" {{ $employee->departemen == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="Operasional" {{ $employee->departemen == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                            <option value="Produksi" {{ $employee->departemen == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="jabatan" class="form-control" value="{{ $employee->jabatan }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="{{ $employee->tanggal_masuk->format('Y-m-d') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Gaji Dasar (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="gaji_dasar" class="form-control" value="{{ $employee->gaji_dasar }}" min="0" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3">{{ $employee->alamat }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No. Rekening</label>
                        <input type="text" name="no_rekening" class="form-control" value="{{ $employee->no_rekening }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Bank</label>
                        <input type="text" name="nama_bank" class="form-control" value="{{ $employee->nama_bank }}">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">NPWP</label>
                <input type="text" name="npwp" class="form-control" value="{{ $employee->npwp }}">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" {{ $employee->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ $employee->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-outline-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
