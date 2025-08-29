<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransformationController;
use App\Http\Controllers\HealthCheckController;

Route::middleware('throttle:web')->group(function () {
    Route::get('/up', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toIso8601String(),
        'version' => '3.0.0',
        'environment' => config('app.env')
    ]);
})->name('health');

Route::get('/health', HealthCheckController::class);

Route::get('/readiness', function () {
    return response('OK', 200);
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/hubs', function () {
})->name('hubs.index');
Route::get('/hub/{category}', [\App\Http\Controllers\ContentHubController::class, 'show'])->name('hub.show');
Route::get('/hub/{category}/metrics', [\App\Http\Controllers\ContentHubController::class, 'metricsApi'])->name('hub.metrics');

Route::get('/converter', [TransformationController::class, 'transform'])->name('converter');
Route::post('/converter', [TransformationController::class, 'transform'])->name('transform');

Route::get('/case-changer', [TransformationController::class, 'transform'])->name('case-changer');
Route::get('/modern', [TransformationController::class, 'transform'])->name('modern-case-changer');

Route::get('/api/tools/validation-status', [HomeController::class, 'validationStatus'])->name('api.tools.validation-status');

Route::get('/conversions', [ConversionController::class, 'index'])->name('conversions.index');
Route::get('/conversions/{category}', [ConversionController::class, 'category'])->name('conversions.category');
Route::get('/conversions/{category}/{tool}', [ConversionController::class, 'tool'])->name('conversions.tool');

Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/api/conversions/{category}', [ConversionController::class, 'getCategoryData']);
    Route::get('/api/conversions', [ConversionController::class, 'getAllCategories']);
});

Route::get('/sitemap', function() {
    return view('sitemap');
})->name('sitemap');

Route::get('/terms', function() {
    return view('legal.terms');
})->name('terms');

Route::get('/privacy', function() {
    return view('legal.privacy');
})->name('privacy');

Route::get('/cookies', function() {
    return view('legal.cookies');
})->name('cookies');

Route::get('/about', function() {
    return view('pages.about');
})->name('about');

Route::get('/contact', function() {
    return view('pages.contact');
})->name('contact');

Route::get('/faq', function() {
    return view('pages.faq');
})->name('faq');

Route::prefix('qa')->name('qa.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\QADashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/metrics', [App\Http\Controllers\QADashboardController::class, 'metrics'])->name('metrics');
        Route::get('/runs/{runId}', [App\Http\Controllers\QADashboardController::class, 'runDetails'])->name('run-details');
        Route::post('/trigger-run', [App\Http\Controllers\QADashboardController::class, 'triggerRun'])->name('trigger-run');
        Route::get('/flaky-tests', [App\Http\Controllers\QADashboardController::class, 'flakyTests'])->name('flaky-tests');
        Route::get('/performance', [App\Http\Controllers\QADashboardController::class, 'performanceMetrics'])->name('performance');
    });
});
});
