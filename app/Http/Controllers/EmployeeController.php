<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = Employee::query();

        if ($search) {
            $query->cari($search);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $employees = $query->orderBy('nama', 'asc')->paginate(10);

        return view('employees.index', compact('employees', 'search', 'status'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:employees,nip',
            'nama' => 'required',
            'departemen' => 'required',
            'jabatan' => 'required',
            'tanggal_masuk' => 'required|date',
            'gaji_dasar' => 'required|numeric|min:0',
        ]);

        Employee::create($request->only([
            'nip',
            'nama',
            'email',
            'departemen',
            'jabatan',
            'tanggal_masuk',
            'gaji_dasar',
            'no_rekening',
            'nama_bank',
            'npwp',
            'status',
            'alamat',
            'no_hp',
        ]));

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function show(Employee $employee)
    {
        $penggajian = $employee->payrolls()
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('employees.show', compact('employee', 'penggajian'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'nip' => 'required|unique:employees,nip,'.$employee->id,
            'nama' => 'required',
            'departemen' => 'required',
            'jabatan' => 'required',
            'tanggal_masuk' => 'required|date',
            'gaji_dasar' => 'required|numeric|min:0',
        ]);

        $employee->update($request->only([
            'nip',
            'nama',
            'email',
            'departemen',
            'jabatan',
            'tanggal_masuk',
            'gaji_dasar',
            'no_rekening',
            'nama_bank',
            'npwp',
            'status',
            'alamat',
            'no_hp',
        ]));

        return redirect()->route('employees.show', $employee->id)
            ->with('success', 'Data karyawan berhasil diperbarui!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Karyawan berhasil dihapus!');
    }
}
