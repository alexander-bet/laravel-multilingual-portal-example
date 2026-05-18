<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Lead\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use App\MoonShine\Resources\Lead\LeadResource;

/**
 * @extends FormPage<LeadResource>
 */
class LeadFormPage extends FormPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Email', 'email')->readonly(),
            Text::make('Phone', 'phone')->readonly(),
            Text::make('Country code', 'phone_country_code')->readonly(),
            Text::make('Source', 'source')->readonly(),
            Text::make('Locale', 'locale')->readonly(),
            Text::make('IP', 'ip')->readonly(),
            Select::make('Status', 'status')
                ->options([
                    'new'         => 'New',
                    'in_progress' => 'In progress',
                    'closed'      => 'Closed',
                ]),
        ];
    }
}
