<?php

declare(strict_types=1);

namespace Modules\Core\Traits;

use Butschster\Head\Facades\Meta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

trait SetsHreflang
{
    /**
     * Hreflang for pages with no slug (home, blog index, services index, contact).
     * Uses getURLFromRouteNameTranslated so segments are translated per locale.
     *
     * @param string $routeTransKey  e.g. 'routes.blog' or 'routes.services'
     */
    protected function setStaticHreflang(string $routeTransKey): void
    {
        $defaultLocale = LaravelLocalization::getDefaultLocale();

        foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $locale) {
            $url = LaravelLocalization::getURLFromRouteNameTranslated($locale, $routeTransKey);
            if ($url) {
                Meta::setHrefLang($locale, $url);
            }
        }

        $xDefault = LaravelLocalization::getURLFromRouteNameTranslated($defaultLocale, $routeTransKey);
        if ($xDefault) {
            Meta::setHrefLang('x-default', $xDefault);
        }
    }

    /**
     * Hreflang for the home page (no route segment to translate, just locale prefix).
     */
    protected function setHomeHreflang(): void
    {
        $defaultLocale = LaravelLocalization::getDefaultLocale();
        $baseUrl       = url('/');

        foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $locale) {
            $url = LaravelLocalization::getLocalizedURL($locale, $baseUrl);
            if ($url) {
                Meta::setHrefLang($locale, $url);
            }
        }

        Meta::setHrefLang('x-default', LaravelLocalization::getLocalizedURL($defaultLocale, $baseUrl));
    }

    /**
     * Hreflang for detail pages (article, service, category show).
     *
     * Hreflang tags are only emitted for locales that have an actual translation
     * (correct SEO — we don't point search engines at a fallback index page).
     *
     * The language switcher ($localizedUrls shared with all views) gets ALL locales:
     * translated locales receive the correct detail URL; untranslated locales fall
     * back to the section index (e.g. blog or services list) so the user always
     * lands somewhere sensible instead of getting a 404.
     *
     * @param string      $routeTransKey  e.g. 'routes.blog.show'
     * @param object      $model          Model with getLocalizedRouteKey(string $locale): ?string
     * @param string      $param          Route param name, e.g. 'article'
     * @param string|null $fallbackKey    Index route key for missing locales, e.g. 'routes.blog'
     */
    protected function setModelHreflang(
        string $routeTransKey,
        object $model,
        string $param,
        ?string $fallbackKey = null,
    ): void {
        $defaultLocale = LaravelLocalization::getDefaultLocale();
        $detailUrls    = [];

        foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $locale) {
            $slug = $model->getLocalizedRouteKey($locale);
            if (!$slug) {
                continue;
            }
            $url = LaravelLocalization::getURLFromRouteNameTranslated($locale, $routeTransKey, [$param => $slug]);
            if ($url) {
                $detailUrls[$locale] = $url;
            }
        }

        // Hreflang: only confirmed translations
        foreach ($detailUrls as $locale => $url) {
            Meta::setHrefLang($locale, $url);
        }
        $defaultUrl = $detailUrls[$defaultLocale] ?? (reset($detailUrls) ?: null);
        if ($defaultUrl) {
            Meta::setHrefLang('x-default', $defaultUrl);
        }

        // Language switcher: all locales, missing ones fall back to section index
        $switchUrls = $detailUrls;
        if ($fallbackKey) {
            foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $locale) {
                if (!isset($switchUrls[$locale])) {
                    $fallback = LaravelLocalization::getURLFromRouteNameTranslated($locale, $fallbackKey);
                    if ($fallback) {
                        $switchUrls[$locale] = $fallback;
                    }
                }
            }
        }

        view()->share('localizedUrls', $switchUrls);
    }
}
