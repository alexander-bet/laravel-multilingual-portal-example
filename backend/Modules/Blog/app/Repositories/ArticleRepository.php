<?php

declare(strict_types=1);

namespace Modules\Blog\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Blog\Models\Article;
use Modules\Blog\Models\Category;

class ArticleRepository
{
    public function getPaginated(int $perPage = 12): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Article::with(['translations', 'category.translations', 'media'])
            ->published()
            ->whereHas('translations', fn ($q) => $q->where('locale', $locale)->whereNotNull('title')->where('title', '!=', ''))
            ->orderByDesc('published_at')
            ->paginate($perPage);
    }

    public function getPaginatedByCategory(Category $category, int $perPage = 12): LengthAwarePaginator
    {
        $locale = app()->getLocale();

        return Article::with(['translations', 'category.translations', 'media'])
            ->published()
            ->where('category_id', $category->id)
            ->whereHas('translations', fn ($q) => $q->where('locale', $locale)->whereNotNull('title')->where('title', '!=', ''))
            ->orderByDesc('published_at')
            ->paginate($perPage);
    }

    public function getLatestByCategorySlug(string $slug, string $slugLocale = 'ru', int $limit = 9): Collection
    {
        $locale = app()->getLocale();

        $category = Category::whereHas('translations', fn ($q) =>
            $q->where('locale', $slugLocale)->where('slug', $slug)
        )->first();

        if (! $category) {
            return Collection::make();
        }

        return Article::with(['translations', 'media'])
            ->published()
            ->where('category_id', $category->id)
            ->whereHas('translations', fn ($q) => $q->where('locale', $locale)->whereNotNull('title')->where('title', '!=', ''))
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get();
    }

    public function getAllCategories(): Collection
    {
        $locale = app()->getLocale();

        return Category::with('translations')
            ->whereNull('parent_id')
            ->whereHas('translations', fn ($q) => $q->where('locale', $locale)->whereNotNull('name')->where('name', '!=', ''))
            ->orderBy('sort_order')
            ->get();
    }
}
