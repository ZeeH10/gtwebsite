<?php

use App\Http\Controllers\PrayerRequestController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/ministries', 'ministries')->name('ministries');
Route::view('/events', 'events')->name('events');
Route::view('/watch', 'watch')->name('watch');
Route::view('/give', 'give')->name('give');
Route::view('/visit', 'contact')->name('contact');
Route::view('/prayer', 'prayer')->name('prayer');
Route::post('/prayer', [PrayerRequestController::class, 'store'])->middleware('throttle:5,1')->name('prayer.store');
