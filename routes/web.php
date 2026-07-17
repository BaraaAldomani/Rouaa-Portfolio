<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TrainingController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

// SEO endpoints (locale-agnostic, served at the root).
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

// Bare root → default locale (Arabic-first).
Route::redirect('/', '/ar', 301);

// The site, served per locale.
Route::prefix('{locale}')
    ->whereIn('locale', config('app.supported_locales'))
    ->middleware([SetLocale::class])
    ->group(function (): void {
        Route::get('/', HomeController::class)->name('home');
        Route::get('/about', AboutController::class)->name('about');
        Route::get('/services', ServicesController::class)->name('services');
        Route::get('/training', TrainingController::class)->name('training');
        Route::get('/contact', [ContactController::class, 'show'])->name('contact');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    });
