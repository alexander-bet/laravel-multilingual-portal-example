<?php

declare(strict_types=1);

namespace Modules\Core\Providers;

use Illuminate\Routing\Router;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Modules\Core\Http\Middleware\SetLocale;
use Modules\Core\Http\Middleware\SetMetaDefaults;
use Nwidart\Modules\Support\ModuleServiceProvider;

class CoreServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Core';
    protected string $nameLower = 'core';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();

        /** @var Router $router */
        $router = $this->app['router'];

        // Aliases used in every module's localized route group
        $router->aliasMiddleware('localize', LaravelLocalizationRoutes::class);
        $router->aliasMiddleware('localeSessionRedirect', LocaleSessionRedirect::class);
        $router->aliasMiddleware('localeRedirect', LaravelLocalizationRedirectFilter::class);
        $router->aliasMiddleware('setLocale', SetLocale::class);
        $router->aliasMiddleware('setMetaDefaults', SetMetaDefaults::class);
    }
}
