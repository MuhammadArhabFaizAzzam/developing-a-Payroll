<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));
        $status = $request->get('status', '');

        $query = Payroll::with('employee');

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $summaryQuery = clone $query;
        $payrolls = $query->orderBy('employee_id')->paginate(15);

        $totalGaji = (clone $summaryQuery)->sum('gaji_bersih');
        $totalTunjangan = (clone $summaryQuery)->sum('total_tunjangan');
        $totalPotongan = (clone $summaryQuery)->sum('total_potongan');

        return view('payrolls.index', compact(
            'payrolls', 'bulan', 'tahun', 'status',
            'totalGaji', 'totalTunjangan', 'totalPotongan'
        ));
    }

    public function create()
    {
        $bulan = date('n');
        $tahun = date('Y');

        $employees = Employee::where('status', 'aktif')
            ->whereDoesntHave('payrolls', function ($q) use ($bulan, $tahun) {
                $q->where('bulan', $bulan)->where('tahun', $tahun);
            })
            ->get();

        return view('payrolls.create', compact('employees', 'bulan', 'tahun'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|array',
            'employee_id.*' => 'exists:employees,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $created = 0;

        foreach ($request->employee_id as $employeeId) {
            $exists = Payroll::where('employee_id', $employeeId)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->exists();

            if ($exists) {
                continue;
            }

            $employee = Employee::findOrFail($employeeId);

            $data = Payroll::hitungGaji($employee, $bulan, $tahun);
            $data['employee_id'] = $employeeId;
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['status'] = 'pending';

            Payroll::create($data);
            $created++;
        }

        return redirect()->route('payrolls.index')
            ->with('success', "$created data penggajian berhasil diproses!");
    }

    public function lunaskan(Request $request, Payroll $payroll)
    {
        $payroll->update([
            'status' => 'dibayar',
            'tanggal_bayar' => date('Y-m-d'),
        ]);

        return back()->with('success', 'Penggajian berhasil dilunasi!');
    }

    public function lunaskanBatch(Request $request)
    {
        $request->validate([
            'payroll_ids' => 'required|array',
            'payroll_ids.*' => 'exists:payrolls,id',
        ]);

        Payroll::whereIn('id', $request->payroll_ids)->update([
            'status' => 'dibayar',
            'tanggal_bayar' => date('Y-m-d'),
        ]);

        return back()->with('success', count($request->payroll_ids).' data penggajian berhasil dilunasi!');
    }

    public function slipGaji(Payroll $payroll)
    {
        $payroll->load('employee');

        return view('payrolls.slip-gaji', compact('payroll'));
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return back()->with('success', 'Data penggajian berhasil dihapus!');
    }
}
