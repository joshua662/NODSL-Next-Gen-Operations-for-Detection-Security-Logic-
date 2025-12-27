<?php

use App\Http\Controllers\Api\GateController;
use App\Http\Controllers\Api\ResidentController;
use Illuminate\Support\Facades\Route;

// Gate Operation API (public endpoint - can be secured with API key if needed)
Route::prefix('gate')->group(function () {
    Route::post('/verify', [GateController::class, 'verifyPlate']);
    Route::post('/log-event', [GateController::class, 'logEvent']);
});

// Resident Mobile App API (requires authentication)
Route::middleware(['auth'])->prefix('resident')->group(function () {
    Route::get('/profile', [ResidentController::class, 'getProfile']);
    Route::put('/profile', [ResidentController::class, 'updateProfile']);
    Route::get('/logs', [ResidentController::class, 'getLogs']);
    Route::get('/notifications', [ResidentController::class, 'getNotifications']);
    Route::post('/notifications/{notification}/read', [ResidentController::class, 'markAsRead']);
    Route::post('/update-request', [ResidentController::class, 'submitUpdateRequest']);
    Route::get('/update-requests', [ResidentController::class, 'getUpdateRequests']);
});

