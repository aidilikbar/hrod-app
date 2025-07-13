<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrgChartController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Org chart page
    Route::get('/orgchart', function () {
        return view('orgchart');
    })->name('orgchart');
    //Route::get('/orgchart', [OrgChartController::class, 'index'])->name('orgchart.index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('positions', PositionController::class);
});

require __DIR__.'/auth.php';
