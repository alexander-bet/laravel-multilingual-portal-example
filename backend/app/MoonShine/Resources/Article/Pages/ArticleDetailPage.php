<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Article\Pages;

use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use App\MoonShine\Resources\Article\ArticleResource;

/**
 * @extends DetailPage<ArticleResource>
 */
class ArticleDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Title', 'title'),
            Text::make('Category', 'category.name'),
            Select::make('Status', 'status')
                ->options(['draft' => 'Draft', 'published' => 'Published']),
            Date::make('Published at', 'published_at')->format('d.m.Y H:i'),
            Text::make('Slug', 'slug'),
            Textarea::make('Excerpt', 'excerpt'),
            Text::make('Meta Title', 'meta_title'),
            Textarea::make('Meta Description', 'meta_description'),
            Date::make('Created at', 'created_at')->format('d.m.Y H:i'),
            Date::make('Updated at', 'updated_at')->format('d.m.Y H:i'),
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
