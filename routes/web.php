<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CaseChanger;
use App\Livewire\ModernCaseChanger;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\HomeController;

// Homepage - Universal Converter (One Tool to Rule Them All)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Legacy routes (redirect to home)
Route::get('/case-changer', function() {
    return redirect('/');
})->name('case-changer');
Route::get('/modern', function() {
    return redirect('/');
})->name('modern-case-changer');

// Sitemap
Route::get('/sitemap', function() {
    return view('sitemap');
})->name('sitemap');

// Additional conversions route for backward compatibility
Route::get('/conversions', [ConversionController::class, 'index'])->name('conversions.index');
Route::get('/conversions/{category}', [ConversionController::class, 'category'])->name('conversions.category');
Route::get('/conversions/{category}/{tool}', [ConversionController::class, 'tool'])->name('conversions.tool');

// API routes for dynamic data
Route::get('/api/conversions/{category}', [ConversionController::class, 'getCategoryData']);
Route::get('/api/conversions', [ConversionController::class, 'getAllCategories']);
