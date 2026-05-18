<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Pricing\Pages;

use App\MoonShine\Resources\Pricing\PricingPlanResource;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * @extends FormPage<PricingPlanResource>
 */
class PricingPlanFormPage extends FormPage
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
                ->placeholder('Personal / Персональный'),
            Textarea::make('Features', "{$locale}_features")
                ->hint('One feature per line / Одна характеристика на строку')
                ->customAttributes(['rows' => 6])
                ->placeholder("Feature 1\nFeature 2\nFeature 3"),
        ]), $locales);

        return [
            Text::make('Price', 'price')
                ->required()
                ->hint('Full display price, e.g. $399 or от $5000')
                ->placeholder('$399'),
            Switcher::make('Active', 'is_active')->default(true),
            Number::make('Sort order', 'sort_order')
                ->default(0)
                ->min(0),
            Box::make('Translations', [
                Tabs::make($tabs),
            ]),
        ];
    }
}
