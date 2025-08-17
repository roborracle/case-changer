<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CaseChanger;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/case-changer', CaseChanger::class)->name('case-changer');
