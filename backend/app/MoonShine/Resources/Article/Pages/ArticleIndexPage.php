<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Article\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use App\MoonShine\Resources\Article\ArticleResource;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends IndexPage<ArticleResource>
 */
class ArticleIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Title', 'title')->sortable(),
            Text::make('Category', 'category.name'),
            Select::make('Status', 'status')
                ->options(['draft' => 'Draft', 'published' => 'Published'])
                ->sortable(),
            Date::make('Published', 'published_at')
                ->format('d.m.Y')
                ->sortable(),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            Select::make('Status', 'status')
                ->options(['draft' => 'Draft', 'published' => 'Published'])
                ->nullable(),
        ];
    }

    /**
     * @return list<QueryTag>
     */
    protected function queryTags(): array
    {
        return [
            QueryTag::make('All', fn (Builder $q) => $q)->default(),
            QueryTag::make('Published', fn (Builder $q) => $q->where('status', 'published')),
            QueryTag::make('Draft', fn (Builder $q) => $q->where('status', 'draft')),
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
