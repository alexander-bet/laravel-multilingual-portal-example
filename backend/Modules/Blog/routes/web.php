<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Blog\Http\Controllers\BlogController;

Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'setLocale', 'setMetaDefaults'],
], function () {
    Route::get(LaravelLocalization::transRoute('routes.blog'), [BlogController::class, 'index'])->name('blog.index');
    Route::get(LaravelLocalization::transRoute('routes.blog.category'), [BlogController::class, 'category'])->name('blog.category');
    Route::get(LaravelLocalization::transRoute('routes.blog.show'), [BlogController::class, 'show'])->name('blog.show');
});
