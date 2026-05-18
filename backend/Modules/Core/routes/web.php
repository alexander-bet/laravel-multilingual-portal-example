<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Core\Http\Controllers\AboutController;
use Modules\Core\Http\Controllers\HomeController;
use Modules\Core\Http\Controllers\LegalController;
use Modules\Core\Http\Controllers\SearchController;

Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'setLocale', 'setMetaDefaults'],
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get(LaravelLocalization::transRoute('routes.about'), AboutController::class)->name('about.index');
    Route::get(LaravelLocalization::transRoute('routes.privacy'), [LegalController::class, 'privacy'])->name('privacy');
    Route::get(LaravelLocalization::transRoute('routes.terms'),   [LegalController::class, 'terms'])->name('terms');
    Route::get('/search', SearchController::class)->name('search');
});

/*
 * Language switcher route — lives OUTSIDE the localization middleware group
 * so it can update the session before the localeSessionRedirect middleware
 * reads it, preventing redirect loops when switching to the default locale.
 */
Route::get('/lang/{locale}', function (string $locale) {
    if (LaravelLocalization::checkLocaleInSupportedLocales($locale)) {
        session(['locale' => $locale]);
    }

    // Model pages (articles, services, categories) pass a pre-built localized
    // URL via `redirect_to` so the correct per-locale slug is used.
    // Validate that the target belongs to our own domain to prevent open redirect.
    if ($redirectTo = request()->query('redirect_to')) {
        $parsedTarget  = parse_url($redirectTo, PHP_URL_HOST);
        $parsedAppHost = parse_url(config('app.url'), PHP_URL_HOST);

        if (!$parsedTarget || $parsedTarget === $parsedAppHost) {
            return redirect($redirectTo);
        }
    }

    $url = LaravelLocalization::getLocalizedURL($locale, url()->previous('/'));

    return redirect($url);
})
    ->name('lang.switch')
    ->where('locale', '[a-z]{2,3}');
