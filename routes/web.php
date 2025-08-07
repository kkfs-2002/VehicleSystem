<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\VehicleController as AdminVehicleController;
use App\Http\Controllers\DashboardController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    // Customer routes
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles/store', [VehicleController::class, 'store'])->name('vehicles.store');

    // In routes/web.php
Route::post('/vehicles/{id}/approve', [VehicleController::class, 'approve'])->name('admin.vehicle.approve');
Route::post('/vehicles/{id}/reject', [VehicleController::class, 'reject'])->name('admin.vehicle.reject');
Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy'])->name('admin.vehicle.delete');

    // Logout route
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
    // Admin routes
    Route::middleware('isAdmin')->group(function () {
        Route::get('/admin/dashboard', [AdminVehicleController::class, 'index'])->name('admin.dashboard');
        Route::post('/admin/vehicles/{id}/approve', [AdminVehicleController::class, 'approve'])->name('admin.vehicle.approve');
        Route::post('/admin/vehicles/{id}/reject', [AdminVehicleController::class, 'reject'])->name('admin.vehicle.reject');
        Route::delete('/admin/vehicles/{id}', [AdminVehicleController::class, 'destroy'])->name('admin.vehicle.delete');
    });
});