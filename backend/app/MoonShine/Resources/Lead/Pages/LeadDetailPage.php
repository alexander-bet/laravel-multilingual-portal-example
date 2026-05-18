<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Lead\Pages;

use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use App\MoonShine\Resources\Lead\LeadResource;

/**
 * @extends DetailPage<LeadResource>
 */
class LeadDetailPage extends DetailPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Email', 'email'),
            Text::make('Phone', 'phone'),
            Text::make('Country code', 'phone_country_code'),
            Text::make('Service', 'service.title'),
            Text::make('Source', 'source'),
            Text::make('Locale', 'locale'),
            Text::make('Status', 'status'),
            Text::make('IP', 'ip'),
            Date::make('Created', 'created_at')->format('d.m.Y H:i'),
        ];
    }
}
