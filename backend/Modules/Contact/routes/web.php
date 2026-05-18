<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Contact\Http\Controllers\ContactController;
use Modules\Contact\Http\Controllers\LeadController;

Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'setLocale', 'setMetaDefaults'],
], function () {
    Route::get(LaravelLocalization::transRoute('routes.contact'), [ContactController::class, 'index'])->name('contact.index');
    Route::post(LaravelLocalization::transRoute('routes.contact'), [ContactController::class, 'store'])->name('contact.store');
});

// Lead capture form — AJAX endpoint, no locale prefix needed
Route::post('/leads', [LeadController::class, 'store'])->name('leads.store')->middleware('web');
