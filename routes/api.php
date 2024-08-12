<?php

use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SaleController;
use App\Http\Controllers\API\SaleFormController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Create a new token
    $token = $user->createToken('access-token')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::middleware('auth:sanctum')->group(function () {

    // Fetch products by company ID
    Route::get('/products', [ProductController::class, 'index']);

    Route::get('/sale-form-data', [SaleController::class, 'fetchSaleFormData']);

    // Submit a sale
    Route::post('/sales', [SaleController::class, 'store']);

    // Fetch dashboard data
    Route::get('/dashboard', [DashboardController::class, 'index']);

});
