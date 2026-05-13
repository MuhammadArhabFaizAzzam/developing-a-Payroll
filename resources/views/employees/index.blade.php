@extends('layouts.app')

@section('title', 'Daftar Karyawan')

@section('content')
@include('partials.page-header', [
    'title' => 'Daftar Karyawan',
    'subtitle' => 'Kelola data karyawan penerima gaji',
    'action' => '<a href="' . route('employees.create') . '" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Karyawan</a>',
])

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Cari</label>
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Nama, NIP, atau Departemen"
                    value="{{ $search }}"
                >
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ $status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Gaji Dasar</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $no => $employee)
                        <tr>
                            <td>{{ $no + $employees->firstItem() }}</td>
                            <td>{{ $employee->nip }}</td>
                            <td>
                                <a href="{{ route('employees.show', $employee->id) }}" class="text-primary fw-bold">
                                    {{ $employee->nama }}
                                </a>
                            </td>
                            <td>{{ $employee->departemen }}</td>
                            <td>{{ $employee->jabatan }}</td>
                            <td>Rp {{ number_format($employee->gaji_dasar, 0, ',', '.') }}</td>
                            <td>
                                @include('partials.status-badge', ['status' => $employee->status])
                            </td>
                            <td>
                                <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-outline-info" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form
                                    method="POST"
                                    action="{{ route('employees.destroy', $employee->id) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin hapus?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            @include('partials.table-empty', ['colspan' => 8, 'message' => 'Belum ada data karyawan'])
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($employees->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $employees->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

