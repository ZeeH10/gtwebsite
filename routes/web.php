<?php

use App\Http\Controllers\PrayerRequestController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::post('/prayer', [PrayerRequestController::class, 'store'])->middleware('throttle:5,1')->name('prayer.store');
