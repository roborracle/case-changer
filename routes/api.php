<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransformationApiController;

Route::post('/transform', [TransformationApiController::class, 'transform']);
Route::get('/transformations', [TransformationApiController::class, 'transformations']);
Route::get('/categories', [TransformationApiController::class, 'categories']);