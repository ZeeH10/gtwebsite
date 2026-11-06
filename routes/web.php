<?php

use App\Http\Controllers\ConnectCardController;
use App\Http\Controllers\PrayerRequestController;
use Illuminate\Support\Facades\Route;

$pages = [
    '/' => ['home', 'home'],
    '/about' => ['about', 'about'],
    '/ministries' => ['ministries', 'ministries'],
    '/events' => ['events', 'events'],
    '/watch' => ['watch', 'watch'],
    '/give' => ['give', 'give'],
    '/visit' => ['contact', 'contact'],
    '/connect' => ['connect', 'connect'],
    '/prayer' => ['prayer', 'prayer'],
    '/privacy' => ['privacy', 'privacy'],
];

foreach ($pages as $uri => [$view, $name]) {
    Route::view($uri, $view)->name($name);
}

Route::post('/prayer', [PrayerRequestController::class, 'store'])->middleware('throttle:5,1')->name('prayer.store');
Route::post('/connect', [ConnectCardController::class, 'store'])->middleware('throttle:5,1')->name('connect.store');

Route::get('/sitemap.xml', fn () => response()
    ->view('sitemap', ['urls' => array_map(fn ($uri) => url($uri), array_keys($pages))])
    ->header('Content-Type', 'application/xml'))->name('sitemap');

Route::view('/offline', 'offline')->name('offline'); // cached by public/sw.js for the PWA

Route::get('/robots.txt', fn () => response("User-agent: *\nDisallow: /admin\n\nSitemap: ".route('sitemap')."\n")
    ->header('Content-Type', 'text/plain'));
