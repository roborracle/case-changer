<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CaseChanger;
use App\Livewire\ModernCaseChanger;
use App\Http\Controllers\ConversionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/case-changer', CaseChanger::class)->name('case-changer');
Route::get('/modern', ModernCaseChanger::class)->name('modern-case-changer');

// Sitemap
Route::get('/sitemap', function() {
    return view('sitemap');
})->name('sitemap');

// Conversion tools hierarchical routes
Route::get('/conversions', [ConversionController::class, 'index'])->name('conversions.index');
Route::get('/conversions/{category}', [ConversionController::class, 'category'])->name('conversions.category');
Route::get('/conversions/{category}/{tool}', [ConversionController::class, 'tool'])->name('conversions.tool');

// API routes for dynamic data
Route::get('/api/conversions/{category}', [ConversionController::class, 'getCategoryData']);
Route::get('/api/conversions', [ConversionController::class, 'getAllCategories']);
