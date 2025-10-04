<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\AuthController;

// 🔹 Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// 🔹 Default Sanctum user info route
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 🔹 Public search routes (no auth required)
Route::prefix('search')->group(function () {
    Route::get('/', [SearchController::class, 'search']);                  // Unified search
    Route::get('/suggestions', [SearchController::class, 'suggestions']);  // Typeahead suggestions
});

// 🔒 Admin-only routes (auth + admin middleware)
Route::middleware(['auth:sanctum', 'admin'])->prefix('search')->group(function () {
    Route::get('/logs', [SearchController::class, 'getSearchLogs']);           // View search logs
    Route::get('/analytics', [SearchController::class, 'getSearchAnalytics']); // Analytics
    Route::post('/rebuild-index', [SearchController::class, 'rebuildIndex']);  // Rebuild search index
});
