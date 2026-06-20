<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IntakeController;
use App\Http\Controllers\ServicePresetController;
use App\Http\Controllers\PartReferenceController;
use App\Http\Controllers\ReportController;
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/intake', [IntakeController::class, 'create'])->name('intake.create');
Route::post('/intake', [IntakeController::class, 'store'])->name('intake.store');

require __DIR__ . '/jobs.php';

Route::resource('customers', CustomerController::class);
Route::resource('cars', CarController::class);
Route::resource('presets', ServicePresetController::class);
Route::resource('parts', PartReferenceController::class);

Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/', function () { return redirect()->route('reports.revenue'); });
    Route::get('/revenue', [ReportController::class, 'revenue'])->name('revenue');
    Route::get('/outstanding', [ReportController::class, 'outstanding'])->name('outstanding');
    Route::get('/job-status', [ReportController::class, 'jobStatus'])->name('job_status');
    Route::get('/services-parts', [ReportController::class, 'servicesParts'])->name('services_parts');
});
