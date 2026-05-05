<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()?->role === 'admin') {
            return $this->adminDashboard();
        }

        return app(UserDashboardController::class)->index($request);
    }

    private function adminDashboard()
    {
        $totalKaryawan = Employee::count();
        $karyawanAktif = Employee::where('status', 'aktif')->count();
        $totalGajiBulanIni = Payroll::where('bulan', date('n'))
            ->where('tahun', date('Y'))
            ->where('status', 'dibayar')
            ->sum('gaji_bersih');
        $totalGaji = Payroll::where('status', 'dibayar')->sum('gaji_bersih');
        $penggajianPending = Payroll::where('status', 'pending')->count();

        $karyawanTerbaru = Employee::orderBy('created_at', 'desc')->take(5)->get();

        $penggajianTerbaru = Payroll::with('employee')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $departemen = Employee::select('departemen')
            ->groupBy('departemen')
            ->get()
            ->pluck('departemen');

        $gajiPerDepartemen = [];
        foreach ($departemen as $dept) {
            $total = Payroll::whereHas('employee', function ($q) use ($dept) {
                $q->where('departemen', $dept);
            })
                ->where('status', 'dibayar')
                ->sum('gaji_bersih');
            $gajiPerDepartemen[$dept] = $total;
        }

        return view('dashboard', compact(
            'totalKaryawan',
            'karyawanAktif',
            'totalGajiBulanIni',
            'totalGaji',
            'penggajianPending',
            'karyawanTerbaru',
            'penggajianTerbaru',
            'gajiPerDepartemen'
        ));
    }
}
