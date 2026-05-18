<?php

declare(strict_types=1);

namespace Tests\Feature\Repository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Blog\Database\Factories\ArticleFactory;
use Modules\Blog\Database\Factories\CategoryFactory;
use Modules\Blog\Repositories\ArticleRepository;
use Tests\TestCase;

class ArticleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ArticleRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(ArticleRepository::class);
    }

    // ── getPaginated ──────────────────────────────────────────────────────────

    public function test_get_paginated_returns_published_articles(): void
    {
        ArticleFactory::new()->withTranslation('ru')->count(3)->create();

        $result = $this->repository->getPaginated();

        $this->assertCount(3, $result);
    }

    public function test_get_paginated_excludes_draft_articles(): void
    {
        ArticleFactory::new()->withTranslation('ru')->create();
        ArticleFactory::new()->draft()->withTranslation('ru')->create();

        $result = $this->repository->getPaginated();

        $this->assertCount(1, $result);
    }

    public function test_get_paginated_excludes_future_published_articles(): void
    {
        ArticleFactory::new()->withTranslation('ru')->create();
        ArticleFactory::new()->futurePublished()->withTranslation('ru')->create();

        $result = $this->repository->getPaginated();

        $this->assertCount(1, $result);
    }

    public function test_get_paginated_excludes_articles_without_locale_translation(): void
    {
        ArticleFactory::new()->withTranslation('ru')->create();
        // This article exists but has no Russian translation
        ArticleFactory::new()->withTranslation('en')->create();

        app()->setLocale('ru');

        $result = $this->repository->getPaginated();

        $this->assertCount(1, $result);
    }

    public function test_get_paginated_respects_per_page(): void
    {
        ArticleFactory::new()->withTranslation('ru')->count(5)->create();

        $result = $this->repository->getPaginated(3);

        $this->assertCount(3, $result);
        $this->assertEquals(5, $result->total());
    }

    public function test_get_paginated_orders_by_published_at_descending(): void
    {
        $old    = ArticleFactory::new()->state(['published_at' => now()->subDays(5)])->withTranslation('ru')->create();
        $recent = ArticleFactory::new()->state(['published_at' => now()->subDay()])->withTranslation('ru')->create();

        $result = $this->repository->getPaginated();

        $this->assertEquals($recent->id, $result->first()->id);
        $this->assertEquals($old->id, $result->last()->id);
    }

    // ── getPaginatedByCategory ────────────────────────────────────────────────

    public function test_get_paginated_by_category_returns_only_articles_in_that_category(): void
    {
        $category = CategoryFactory::new()->withTranslation('ru')->create();
        $other    = CategoryFactory::new()->withTranslation('ru')->create();

        ArticleFactory::new()->state(['category_id' => $category->id])->withTranslation('ru')->count(2)->create();
        ArticleFactory::new()->state(['category_id' => $other->id])->withTranslation('ru')->create();

        $result = $this->repository->getPaginatedByCategory($category);

        $this->assertCount(2, $result);
        $this->assertTrue($result->every(fn ($a) => $a->category_id === $category->id));
    }

    // ── getAllCategories ──────────────────────────────────────────────────────

    public function test_get_all_categories_returns_only_root_categories(): void
    {
        $parent = CategoryFactory::new()->withTranslation('ru')->create();
        // Child category
        CategoryFactory::new()
            ->state(['parent_id' => $parent->id])
            ->withTranslation('ru')
            ->create();

        $result = $this->repository->getAllCategories();

        $this->assertCount(1, $result);
        $this->assertEquals($parent->id, $result->first()->id);
    }

    public function test_get_all_categories_excludes_those_without_locale_translation(): void
    {
        CategoryFactory::new()->withTranslation('ru')->create();
        CategoryFactory::new()->withTranslation('en')->create();

        app()->setLocale('ru');

        $result = $this->repository->getAllCategories();

        $this->assertCount(1, $result);
    }

    // ── getLatestByCategorySlug ───────────────────────────────────────────────

    public function test_get_latest_by_category_slug_returns_empty_when_category_not_found(): void
    {
        $result = $this->repository->getLatestByCategorySlug('nonexistent-slug');

        $this->assertCount(0, $result);
    }

    public function test_get_latest_by_category_slug_returns_articles_in_that_category(): void
    {
        $category = CategoryFactory::new()
            ->withTranslation('ru', ['slug' => 'novosti'])
            ->create();

        ArticleFactory::new()
            ->state(['category_id' => $category->id])
            ->withTranslation('ru')
            ->count(3)
            ->create();

        $result = $this->repository->getLatestByCategorySlug('novosti', 'ru');

        $this->assertCount(3, $result);
    }

    public function test_get_latest_by_category_slug_respects_limit(): void
    {
        $category = CategoryFactory::new()
            ->withTranslation('ru', ['slug' => 'novosti'])
            ->create();

        ArticleFactory::new()
            ->state(['category_id' => $category->id])
            ->withTranslation('ru')
            ->count(10)
            ->create();

        $result = $this->repository->getLatestByCategorySlug('novosti', 'ru', 5);

        $this->assertCount(5, $result);
    }
}
