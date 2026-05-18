<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Lead\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use App\MoonShine\Resources\Lead\LeadResource;

/**
 * @extends IndexPage<LeadResource>
 */
class LeadIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Email', 'email')->sortable(),
            Text::make('Phone', 'phone'),
            Text::make('Service', 'service.title'),
            Text::make('Source', 'source')->sortable(),
            Text::make('Locale', 'locale')->sortable(),
            Select::make('Status', 'status')
                ->options([
                    'new'         => 'New',
                    'in_progress' => 'In progress',
                    'closed'      => 'Closed',
                ])
                ->sortable(),
            Date::make('Date', 'created_at')->sortable()->format('d.m.Y H:i'),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            Select::make('Status', 'status')
                ->options([
                    'new'         => 'New',
                    'in_progress' => 'In progress',
                    'closed'      => 'Closed',
                ]),
            Text::make('Source', 'source'),
            Text::make('Locale', 'locale'),
        ];
    }

    /**
     * @return list<QueryTag>
     */
    protected function queryTags(): array
    {
        return [
            QueryTag::make('New', fn ($q) => $q->where('status', 'new'))->default(),
            QueryTag::make('In progress', fn ($q) => $q->where('status', 'in_progress')),
            QueryTag::make('Closed', fn ($q) => $q->where('status', 'closed')),
            QueryTag::make('All', fn ($q) => $q),
        ];
    }
}
