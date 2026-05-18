<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Blog\Models\Article;
use Modules\Services\Models\Service;

class SearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $q      = trim((string) $request->string('q'));
        $locale = app()->getLocale();

        if (mb_strlen($q) < 2) {
            return response()->json(['articles' => [], 'services' => []]);
        }

        $articles = Article::with(['translations', 'media'])
            ->where('status', 'published')
            ->whereHas('translations', function ($query) use ($locale, $q) {
                $query->where('locale', $locale)
                    ->where(function ($sub) use ($q) {
                        $sub->where('title', 'ilike', "%{$q}%")
                            ->orWhere('excerpt', 'ilike', "%{$q}%");
                    });
            })
            ->limit(5)
            ->get()
            ->map(function (Article $article) use ($locale) {
                $slug = $article->getLocalizedRouteKey($locale);
                $url  = $slug
                    ? LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.blog.show', ['article' => $slug])
                    : LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.blog');

                $image = $article->getFirstMedia('cover');

                return [
                    'title'   => $article->translate($locale)?->title ?? $article->title,
                    'excerpt' => $article->translate($locale)?->excerpt ?? $article->excerpt,
                    'url'     => $url,
                    'image'   => $image ? ($image->getUrl('thumb') ?: $image->getUrl()) : null,
                ];
            });

        $services = Service::with(['translations', 'media'])
            ->where('status', 'published')
            ->whereHas('translations', function ($query) use ($locale, $q) {
                $query->where('locale', $locale)
                    ->where(function ($sub) use ($q) {
                        $sub->where('title', 'ilike', "%{$q}%")
                            ->orWhere('excerpt', 'ilike', "%{$q}%");
                    });
            })
            ->limit(4)
            ->get()
            ->map(function (Service $service) use ($locale) {
                $slug = $service->getLocalizedRouteKey($locale);
                $url  = $slug
                    ? LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.services.show', ['service' => $slug])
                    : LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.services');

                return [
                    'title'   => $service->translate($locale)?->title ?? $service->title,
                    'excerpt' => $service->translate($locale)?->excerpt ?? $service->excerpt,
                    'url'     => $url,
                ];
            });

        return response()->json([
            'articles' => $articles->values(),
            'services' => $services->values(),
        ]);
    }
}
