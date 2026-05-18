<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Category;

use Modules\Blog\Models\Category;
use App\MoonShine\Resources\Category\Pages\CategoryIndexPage;
use App\MoonShine\Resources\Category\Pages\CategoryFormPage;
use App\MoonShine\Resources\Category\Pages\CategoryDetailPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Category, CategoryIndexPage, CategoryFormPage, CategoryDetailPage>
 */
class CategoryResource extends ModelResource
{
    protected string $model = Category::class;

    protected string $title = 'Categories';

    protected string $sortColumn = 'sort_order';
    protected SortDirection $sortDirection = SortDirection::ASC;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            CategoryIndexPage::class,
            CategoryFormPage::class,
            CategoryDetailPage::class,
        ];
    }

    protected function query(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::query()->with(['translations', 'parent.translations']);
    }
}
