<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapAuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomeController::class)->name('home');
Route::redirect('/ios', 'https://apps.apple.com/de/app/mein-moers/id1305862555?mt=8')->name('apps.ios');
Route::redirect('/android', 'https://play.google.com/store/apps/details?id=com.lambdadigamma.moers')->name('apps.android');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/maps/auth', [MapAuthController::class, 'token']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
