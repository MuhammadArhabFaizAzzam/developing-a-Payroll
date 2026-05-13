<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\User;
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

    public function approveJobChoice(User $user)
    {
        if (! $user->desired_department || ! $user->desired_job) {
            return back()->with('error', 'User belum memilih pekerjaan.');
        }

        Employee::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nip' => $this->generateEmployeeNip($user),
                'nama' => $user->name,
                'email' => $user->email,
                'departemen' => $user->desired_department,
                'jabatan' => $user->desired_job,
                'tanggal_masuk' => now()->toDateString(),
                'gaji_dasar' => 0,
                'status' => 'aktif',
            ],
        );

        $user->update([
            'desired_job_status' => 'diterima',
        ]);

        return back()->with('success', 'Pilihan pekerjaan user berhasil diterima.');
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
        $pilihanPekerjaanPending = User::whereNotNull('desired_job')->count();

        $karyawanTerbaru = Employee::orderBy('created_at', 'desc')->take(5)->get();

        $penggajianTerbaru = Payroll::with('employee')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $pilihanPekerjaanTerbaru = User::query()
            ->whereNotNull('desired_job')
            ->orderByDesc('updated_at')
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
            'pilihanPekerjaanPending',
            'karyawanTerbaru',
            'penggajianTerbaru',
            'pilihanPekerjaanTerbaru',
            'gajiPerDepartemen'
        ));
    }

    private function generateEmployeeNip(User $user): string
    {
        $existingEmployee = Employee::where('user_id', $user->id)->first();

        if ($existingEmployee) {
            return $existingEmployee->nip;
        }

        return 'USR'.str_pad((string) $user->id, 5, '0', STR_PAD_LEFT);
    }
}
