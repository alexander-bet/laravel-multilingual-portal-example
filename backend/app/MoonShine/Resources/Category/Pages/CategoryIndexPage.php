<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Category\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use App\MoonShine\Resources\Category\CategoryResource;

/**
 * @extends IndexPage<CategoryResource>
 */
class CategoryIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Name', 'name')->sortable(),
            Text::make('Parent', 'parent.name'),
            Number::make('Sort order', 'sort_order')->sortable(),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [];
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
