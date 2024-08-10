<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::middleware('auth')->get('sales', function () {
        $user = Auth::user();
        $companyId = $user->companies->first()->id ?? null; // Fetch the first company associated with the authenticated user

        if (!$companyId) {
            abort(403, 'No company found for the user.');
        }

        return view('sales', compact('companyId'));
    })->name('sales.form');

require __DIR__ . '/auth.php';
