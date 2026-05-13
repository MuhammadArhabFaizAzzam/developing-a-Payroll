<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function (Request $request) {
    if ($request->user()?->desired_job_status === 'diterima') {
        return redirect()->route('dashboard');
    }

    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::post('user/job-choice', [UserDashboardController::class, 'updateJobChoice'])->name('user.job-choice.update');
    Route::post('user/payrolls/{payroll}/take', [UserDashboardController::class, 'takePayroll'])->name('user.payrolls.take');
    Route::get('user/payrolls/{payroll}/slip-gaji', [UserDashboardController::class, 'slipPayroll'])->name('user.payrolls.slip-gaji');

    Route::middleware('role:admin')->group(function () {
        Route::post('admin/job-choices/{user}/approve', [DashboardController::class, 'approveJobChoice'])->name('admin.job-choices.approve');

        require __DIR__.'/web-payroll.php';
    });
});

require __DIR__.'/settings.php';
