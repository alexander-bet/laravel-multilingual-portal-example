<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Services\Http\Controllers\ServiceController;

Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'setLocale', 'setMetaDefaults'],
], function () {
    Route::get(LaravelLocalization::transRoute('routes.services'), [ServiceController::class, 'index'])->name('services.index');
    Route::get(LaravelLocalization::transRoute('routes.services.show'), [ServiceController::class, 'show'])->name('services.show');
});
