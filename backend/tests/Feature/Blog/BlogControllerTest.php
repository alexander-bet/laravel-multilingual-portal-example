<?php

declare(strict_types=1);

namespace Tests\Feature\Blog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Blog\Database\Factories\ArticleFactory;
use Modules\Blog\Database\Factories\CategoryFactory;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    use RefreshDatabase;

    // ── Index ─────────────────────────────────────────────────────────────────

    public function test_blog_index_returns_200(): void
    {
        $this->get('/blog')->assertOk();
    }

    public function test_blog_index_passes_articles_and_categories_to_view(): void
    {
        ArticleFactory::new()->withTranslation('ru')->count(3)->create();

        $this->get('/blog')
            ->assertOk()
            ->assertViewIs('blog::index')
            ->assertViewHas('articles')
            ->assertViewHas('categories');
    }

    // ── Show ──────────────────────────────────────────────────────────────────

    public function test_show_returns_200_for_published_article(): void
    {
        ArticleFactory::new()
            ->withTranslation('ru', ['slug' => 'test-article'])
            ->create();

        $this->get('/blog/test-article')->assertOk();
    }

    public function test_show_passes_article_to_view(): void
    {
        ArticleFactory::new()
            ->withTranslation('ru', ['slug' => 'my-article', 'title' => 'My Article'])
            ->create();

        $this->get('/blog/my-article')
            ->assertOk()
            ->assertViewIs('blog::show')
            ->assertViewHas('article');
    }

    public function test_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get('/blog/this-does-not-exist')->assertNotFound();
    }

    public function test_show_returns_404_for_wrong_locale_slug(): void
    {
        ArticleFactory::new()
            ->withTranslation('en', ['slug' => 'english-only-slug'])
            ->create();

        // Russian locale cannot resolve an English slug
        $this->get('/blog/english-only-slug')->assertNotFound();
    }

    // ── Category ──────────────────────────────────────────────────────────────

    public function test_category_returns_200(): void
    {
        CategoryFactory::new()
            ->withTranslation('ru', ['slug' => 'test-category'])
            ->create();

        $this->get('/blog/kategoriya/test-category')->assertOk();
    }

    public function test_category_passes_articles_and_category_to_view(): void
    {
        $category = CategoryFactory::new()
            ->withTranslation('ru', ['slug' => 'news'])
            ->create();

        ArticleFactory::new()
            ->state(['category_id' => $category->id])
            ->withTranslation('ru')
            ->count(2)
            ->create();

        $this->get('/blog/kategoriya/news')
            ->assertOk()
            ->assertViewIs('blog::category')
            ->assertViewHas('articles')
            ->assertViewHas('category');
    }

    public function test_category_returns_404_for_nonexistent_slug(): void
    {
        $this->get('/blog/kategoriya/no-such-category')->assertNotFound();
    }
}
