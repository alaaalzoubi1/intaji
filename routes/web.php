<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing'); // بدون .blade.php
})->name('landing');

Route::get('/dashboard', function () {
    return view('dashboard'); // سيبحث عن admin.blade.php
})->name('admin.dashboard');
