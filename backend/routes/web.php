<?php

use Illuminate\Support\Facades\Route;

/*
 * Canonical redirect: /ru/* → /*
 *
 * Russian is the default locale — canonical URLs have no prefix.
 * `hideDefaultLocaleInURL = true` prevents generating /ru/ links, but
 * someone may have bookmarked or indexed /ru/ URLs. This 301 redirect
 * keeps them working while consolidating PageRank to the canonical URL.
 *
 * Must be registered before module routes (which are loaded in service
 * providers) so this catch-all fires first for /ru/... requests.
 */
Route::get('/ru/{path?}', function () {
    $uri = preg_replace('#^/ru(?=/|$)#', '', request()->getRequestUri());

    return redirect($uri ?: '/', 301);
})->where('path', '.*');
