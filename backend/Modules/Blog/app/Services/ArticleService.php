<?php

declare(strict_types=1);

namespace Modules\Blog\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Blog\Models\Category;
use Modules\Blog\Repositories\ArticleRepository;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepository $repository,
    ) {}

    public function listArticles(int $perPage = 12): LengthAwarePaginator
    {
        return $this->repository->getPaginated($perPage);
    }

    public function getArticlesByCategory(Category $category, int $perPage = 12): LengthAwarePaginator
    {
        return $this->repository->getPaginatedByCategory($category, $perPage);
    }

    public function getLatestByCategorySlug(string $slug, string $slugLocale = 'ru', int $limit = 9): Collection
    {
        return $this->repository->getLatestByCategorySlug($slug, $slugLocale, $limit);
    }

    public function listCategories(): Collection
    {
        return $this->repository->getAllCategories();
    }
}
