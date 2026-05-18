<?php

declare(strict_types=1);

namespace Tests\Unit\Blog;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Blog\Models\Category;
use Modules\Blog\Repositories\ArticleRepository;
use Modules\Blog\Services\ArticleService;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    private ArticleService $service;
    private ArticleRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(ArticleRepository::class);
        $this->service    = new ArticleService($this->repository);
    }

    public function test_list_articles_delegates_to_repository_with_default_per_page(): void
    {
        $paginator = $this->createMock(LengthAwarePaginator::class);

        $this->repository
            ->expects($this->once())
            ->method('getPaginated')
            ->with(12)
            ->willReturn($paginator);

        $result = $this->service->listArticles();

        $this->assertSame($paginator, $result);
    }

    public function test_list_articles_passes_custom_per_page_to_repository(): void
    {
        $this->repository
            ->expects($this->once())
            ->method('getPaginated')
            ->with(24);

        $this->service->listArticles(24);
    }

    public function test_list_categories_delegates_to_repository(): void
    {
        $collection = new Collection();

        $this->repository
            ->expects($this->once())
            ->method('getAllCategories')
            ->willReturn($collection);

        $result = $this->service->listCategories();

        $this->assertSame($collection, $result);
    }

    public function test_get_articles_by_category_delegates_to_repository(): void
    {
        $category  = new Category();
        $paginator = $this->createMock(LengthAwarePaginator::class);

        $this->repository
            ->expects($this->once())
            ->method('getPaginatedByCategory')
            ->with($category, 12)
            ->willReturn($paginator);

        $result = $this->service->getArticlesByCategory($category);

        $this->assertSame($paginator, $result);
    }

    public function test_get_latest_by_category_slug_delegates_to_repository(): void
    {
        $collection = new Collection();

        $this->repository
            ->expects($this->once())
            ->method('getLatestByCategorySlug')
            ->with('novosti', 'ru', 9)
            ->willReturn($collection);

        $result = $this->service->getLatestByCategorySlug('novosti', 'ru', 9);

        $this->assertSame($collection, $result);
    }
}
