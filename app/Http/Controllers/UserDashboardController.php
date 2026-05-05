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
                ->paginate(10)
            : Payroll::query()->whereKey(-1)->paginate(10);

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

        return view('user-dashboard', compact('payrolls', 'totalGaji', 'pendingGaji', 'employee'));
    }
}
