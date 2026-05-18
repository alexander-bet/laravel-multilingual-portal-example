<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Article;

use Modules\Blog\Models\Article;
use App\MoonShine\Resources\Article\Pages\ArticleIndexPage;
use App\MoonShine\Resources\Article\Pages\ArticleFormPage;
use App\MoonShine\Resources\Article\Pages\ArticleDetailPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Article, ArticleIndexPage, ArticleFormPage, ArticleDetailPage>
 */
class ArticleResource extends ModelResource
{
    protected string $model = Article::class;

    protected string $title = 'Articles';

    protected string $sortColumn = 'published_at';
    protected SortDirection $sortDirection = SortDirection::DESC;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ArticleIndexPage::class,
            ArticleFormPage::class,
            ArticleDetailPage::class,
        ];
    }

    protected function query(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::query()->with(['translations', 'category.translations', 'media']);
    }
}
