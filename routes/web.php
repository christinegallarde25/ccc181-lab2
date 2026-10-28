<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/dashboard/count', [DashboardController::class, 'updateCount'])->name('dashboard.count');
Route::resource('bookings', BookingController::class)->except('show');
