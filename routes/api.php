<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransformationApiController;
use App\Http\Controllers\Api\ValidationController;
use App\Services\ValidationMetricsCollector;

Route::post('/transform', [TransformationApiController::class, 'transform'])->middleware(['validate:maxSize:1048576,memory:2097152', 'throttle:transform']);
Route::middleware('throttle:api')->group(function () {
    Route::get('/transformations', [TransformationApiController::class, 'transformations']);

    Route::prefix('validation')->group(function () {
        Route::get('/status', [ValidationController::class, 'status']);
        Route::get('/certificate', [ValidationController::class, 'certificate']);
        Route::get('/tool/{tool}', [ValidationController::class, 'validateTool']);
        Route::get('/tool/{tool}/history', [ValidationController::class, 'history']);
        Route::post('/run', [ValidationController::class, 'validateAll']);
    });
});

Route::get('/metrics/validation', function (ValidationMetricsCollector $collector) {
    $metrics = '';
    $tools = app(App\Services\TransformationService::class)->getTransformations();

    foreach (array_keys($tools) as $tool) {
        $toolMetrics = $collector->getMetrics($tool);
        $metrics .= "validation_success_total{tool=\"{$tool}\"} {$toolMetrics['success']}\n";
        $metrics .= "validation_failure_total{tool=\"{$tool}\"} {$toolMetrics['failure']}\n";
        $metrics .= "validation_failure_rate{tool=\"{$tool}\"} {$toolMetrics['failure_rate']}\n";
        $metrics .= "validation_average_execution_time_seconds{tool=\"{$tool}\"} {$toolMetrics['average_execution_time']}\n";
    }

    return response($metrics, 200, ['Content-Type' => 'text/plain']);
});

Route::prefix('validation-logs')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\ValidationLogController::class, 'index']);
    Route::get('/stats', [App\Http\Controllers\Api\ValidationLogController::class, 'stats']);
});
