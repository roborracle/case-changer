<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransformationApiController;
use App\Http\Controllers\Api\ValidationController;

Route::post('/transform', [TransformationApiController::class, 'transform']);
Route::get('/transformations', [TransformationApiController::class, 'transformations']);

// Validation API routes
Route::prefix('validation')->group(function () {
    Route::get('/status', [ValidationController::class, 'status']);
    Route::get('/certificate', [ValidationController::class, 'certificate']);
    Route::get('/tool/{tool}', [ValidationController::class, 'validateTool']);
    Route::get('/tool/{tool}/history', [ValidationController::class, 'history']);
    Route::post('/run', [ValidationController::class, 'validateAll']);
});