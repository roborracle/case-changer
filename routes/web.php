<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransformationController;

// Health check for Railway monitoring
Route::get('/up', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toIso8601String(),
        'version' => '3.0.0',
        'environment' => config('app.env')
    ]);
})->name('health');

// Homepage - Professional Case Changer Pro
Route::get('/', function() {
    return view('home-pro');
})->name('home');
Route::post('/api/transform', [TransformationController::class, 'transform'])->name('transform');

// Legacy routes (redirect to home)
Route::get('/case-changer', function() {
    return redirect('/');
})->name('case-changer');
Route::get('/modern', function() {
    return redirect('/');
})->name('modern-case-changer');

// Additional conversions route for backward compatibility
Route::get('/conversions', [ConversionController::class, 'index'])->name('conversions.index');
Route::get('/conversions/{category}', [ConversionController::class, 'category'])->name('conversions.category');
Route::get('/conversions/{category}/{tool}', [ConversionController::class, 'tool'])->name('conversions.tool');

// API routes for dynamic data with rate limiting
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/api/conversions/{category}', [ConversionController::class, 'getCategoryData']);
    Route::get('/api/conversions', [ConversionController::class, 'getAllCategories']);
});

// Sitemap
Route::get('/sitemap', function() {
    return view('sitemap');
})->name('sitemap');

// Legal Pages
Route::get('/terms', function() {
    return view('legal.terms');
})->name('terms');

Route::get('/privacy', function() {
    return view('legal.privacy');
})->name('privacy');

Route::get('/cookies', function() {
    return view('legal.cookies');
})->name('cookies');

// Information Pages
Route::get('/about', function() {
    return view('pages.about');
})->name('about');

Route::get('/contact', function() {
    return view('pages.contact');
})->name('contact');

Route::get('/faq', function() {
    return view('pages.faq');
})->name('faq');
