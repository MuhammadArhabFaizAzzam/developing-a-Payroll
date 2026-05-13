<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $employee = Employee::query()
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('email', $user->email);
            })
            ->first();

        $payrolls = $employee
            ? Payroll::with('employee')
                ->where('employee_id', $employee->id)
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->limit(5)
                ->get()
            : collect();

        $totalGaji = $employee
            ? Payroll::where('employee_id', $employee->id)
                ->where('status', 'dibayar')
                ->sum('gaji_bersih')
            : 0;

        $pendingGaji = $employee
            ? Payroll::where('employee_id', $employee->id)
                ->where('status', 'pending')
                ->count()
            : 0;

        $jobOptions = Employee::query()
            ->select('departemen', 'jabatan')
            ->whereNotNull('departemen')
            ->whereNotNull('jabatan')
            ->groupBy('departemen', 'jabatan')
            ->orderBy('departemen')
            ->orderBy('jabatan')
            ->get();

        return view('user-dashboard', [
            'employee' => $employee,
            'payrolls' => $payrolls,
            'totalGaji' => $totalGaji,
            'pendingGaji' => $pendingGaji,
            'userName' => $user->name,
            'jobOptions' => $jobOptions,
        ]);
    }

    public function updateJobChoice(Request $request)
    {
        $validated = $request->validate([
            'desired_department' => ['required', 'string', 'max:255'],
            'desired_job' => ['required', 'string', 'max:255'],
        ]);

        $request->user()->update([
            'desired_department' => $validated['desired_department'],
            'desired_job' => $validated['desired_job'],
            'desired_job_status' => 'menunggu_review',
        ]);

        return back()->with('success', 'Pilihan pekerjaan berhasil dikirim ke admin.');
    }

    public function takePayroll(Request $request, Payroll $payroll)
    {
        $user = $request->user();
        $payroll->load('employee');

        if ($payroll->employee?->user_id !== $user->id && $payroll->employee?->email !== $user->email) {
            abort(403);
        }

        if ($payroll->status !== 'dibayar') {
            return back()->with('error', 'Gaji ini belum dibayarkan oleh admin.');
        }

        if ($payroll->taken_at) {
            return back()->with('error', 'Gaji ini sudah pernah diambil.');
        }

        $payroll->update([
            'taken_at' => now(),
        ]);

        return back()->with('success', 'Gaji berhasil diambil.');
    }

    public function slipPayroll(Request $request, Payroll $payroll)
    {
        $user = $request->user();
        $payroll->load('employee');

        if ($payroll->employee?->user_id !== $user->id && $payroll->employee?->email !== $user->email) {
            abort(403);
        }

        if ($payroll->status !== 'dibayar') {
            return back()->with('error', 'Slip gaji belum tersedia karena gaji belum dibayarkan.');
        }

        return view('payrolls.slip-gaji', ['payroll' => $payroll]);
    }
}
