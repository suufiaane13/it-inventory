<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resources accessibles uniquement aux Super Admins
    Route::middleware('superadmin')->group(function () {
        Route::resource('employees', EmployeeController::class);
    });

    // Équipements - lecture pour tous, modification pour super admin uniquement
    Route::get('/equipments', [EquipmentController::class, 'index'])->name('equipments.index');
    Route::get('/equipments/{equipment}', [EquipmentController::class, 'show'])->name('equipments.show');
    Route::middleware('superadmin')->group(function () {
        Route::get('/equipments/create', [EquipmentController::class, 'create'])->name('equipments.create');
        Route::post('/equipments', [EquipmentController::class, 'store'])->name('equipments.store');
        Route::get('/equipments/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipments.edit');
        Route::put('/equipments/{equipment}', [EquipmentController::class, 'update'])->name('equipments.update');
        Route::delete('/equipments/{equipment}', [EquipmentController::class, 'destroy'])->name('equipments.destroy');
    });

    Route::resource('maintenances', MaintenanceController::class);

    // Assignments (accessibles uniquement aux Super Admins)
    Route::middleware('superadmin')->group(function () {
        Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
        Route::post('/assignments/{assignment}/return', [AssignmentController::class, 'return'])->name('assignments.return');
    });

    // Resources réservées aux Super Admins uniquement
    Route::middleware('superadmin')->group(function () {
        Route::resource('departments', DepartmentController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
