<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

Route::resource('jobs', JobController::class);
Route::get('jobs/{job}/print', [JobController::class, 'print'])->name('jobs.print');
Route::post('jobs/{job}/payment', [JobController::class, 'recordPayment'])->name('jobs.payment');
Route::patch('jobs/{job}/status', [JobController::class, 'updateStatus'])->name('jobs.update-status');
