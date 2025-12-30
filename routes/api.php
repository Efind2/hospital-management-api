
<?php
// routes/api.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Dashboard
    Route::get('/dashboard/statistics', [DashboardController::class, 'statistics']);

    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index']);

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('dokters', DokterController::class);
        Route::get('dokters/{dokter}/pasiens', [DokterController::class, 'pasiens']);
    });

    // Admin & Staff routes
    Route::apiResource('pasiens', PasienController::class);
    Route::post('pasiens/{pasien}/change-dokter', [PasienController::class, 'changeDokter']);
    
    // Read-only dokter for staff
    Route::middleware('role:staff')->group(function () {
        Route::get('dokters', [DokterController::class, 'index']);
        Route::get('dokters/{dokter}', [DokterController::class, 'show']);
    });
});