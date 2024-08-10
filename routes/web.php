<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'landing');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('sales', function () {
    $companyId = 1; // Default to a specific company, can be dynamic
    return view('sales', compact('companyId'));
})->name('sales.form');

require __DIR__ . '/auth.php';
