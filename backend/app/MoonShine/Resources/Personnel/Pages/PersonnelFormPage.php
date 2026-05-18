<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Personnel\Pages;

use App\MoonShine\Resources\Personnel\PersonnelResource;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;
use VI\MoonShineSpatieMediaLibrary\Fields\MediaLibrary;

/**
 * @extends FormPage<PersonnelResource>
 */
class PersonnelFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        $locales = config('translatable.locales', ['ru', 'en']);

        $tabs = array_map(fn (string $locale) => Tab::make(strtoupper($locale), [
            Text::make('Name', "{$locale}_name")
                ->required($locale === 'ru')
                ->placeholder('Иван Иванов / Ivan Ivanov'),
            Text::make('Position', "{$locale}_position")
                ->required($locale === 'ru')
                ->placeholder('Менеджер проекта / Project Manager'),
        ]), $locales);

        return [
            MediaLibrary::make('Photo', 'photo'),
            Box::make('Translations', [
                Tabs::make($tabs),
            ]),
            Number::make('Sort order', 'sort_order')
                ->default(0)
                ->min(0),
        ];
    }
}
