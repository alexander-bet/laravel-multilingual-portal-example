<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Category\Pages;

use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use App\MoonShine\Resources\Category\CategoryResource;

/**
 * @extends DetailPage<CategoryResource>
 */
class CategoryDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Name', 'name'),
            Text::make('Slug', 'slug'),
            Text::make('Parent', 'parent.name'),
            Number::make('Sort order', 'sort_order'),
            Textarea::make('Description', 'description'),
            Text::make('Meta Title', 'meta_title'),
            Textarea::make('Meta Description', 'meta_description'),
            Text::make('Created at', 'created_at'),
        ];
    }

    /**
     * @return list<ComponentContract>
     */
    protected function topLayer(): array
    {
        return [...parent::topLayer()];
    }

    /**
     * @return list<ComponentContract>
     */
    protected function mainLayer(): array
    {
        return [...parent::mainLayer()];
    }

    /**
     * @return list<ComponentContract>
     */
    protected function bottomLayer(): array
    {
        return [...parent::bottomLayer()];
    }
}
