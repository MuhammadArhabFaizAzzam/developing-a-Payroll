<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

// Employee Routes
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

// Payroll Routes
Route::get('/payrolls', [PayrollController::class, 'index'])->name('payrolls.index');
Route::get('/payrolls/create', [PayrollController::class, 'create'])->name('payrolls.create');
Route::post('/payrolls/proses', [PayrollController::class, 'proses'])->name('payrolls.proses');
Route::post('/payrolls/{payroll}/lunaskan', [PayrollController::class, 'lunaskan'])->name('payrolls.lunaskan');
Route::post('/payrolls/lunaskan-batch', [PayrollController::class, 'lunaskanBatch'])->name('payrolls.lunaskan-batch');
Route::get('/payrolls/{payroll}/slip-gaji', [PayrollController::class, 'slipGaji'])->name('payrolls.slip-gaji');
Route::delete('/payrolls/{payroll}', [PayrollController::class, 'destroy'])->name('payrolls.destroy');
