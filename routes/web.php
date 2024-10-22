<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AppUserController;
use App\Http\Controllers\Admin\DashboardUserController;
use App\Http\Controllers\Admin\VehicleIncomeController;
use App\Http\Controllers\Admin\DriverSalaryController;

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Add other admin routes here...
    });

    // App Users
    Route::resource('app-users', AppUserController::class);

    // Dashboard Users
    Route::resource('dashboard-users', DashboardUserController::class)->names('dashboard-users');

    // Vehicle Incomes
    Route::get('vehicle-incomes/export-pdf', [VehicleIncomeController::class, 'exportPdf'])->name('vehicle-incomes.export-pdf');
    Route::get('vehicle-incomes/export-word', [VehicleIncomeController::class, 'exportWord'])->name('vehicle-incomes.export-word');
    Route::resource('vehicle-incomes', VehicleIncomeController::class);

    // Driver Salaries
    Route::get('/driver-salaries/calculate', [DriverSalaryController::class, 'calculateSalaries'])->name('driver-salaries.calculate');
    Route::resource('driver-salaries', DriverSalaryController::class);

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/driver-salaries', [DriverSalaryController::class, 'index'])->name('admin.driver-salaries.index');
        Route::put('/admin/driver-salaries/{driver}', [DriverSalaryController::class, 'update'])->name('admin.driver-salaries.update');
    });
});

// Redirect root to admin login
Route::get('/', function () {
    return redirect()->route('admin.login');
});
