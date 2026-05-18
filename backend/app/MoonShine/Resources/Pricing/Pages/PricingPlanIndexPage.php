<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Pricing\Pages;

use App\MoonShine\Resources\Pricing\PricingPlanResource;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Components\Icon;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Switcher;

/**
 * @extends IndexPage<PricingPlanResource>
 */
class PricingPlanIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Preview::make(
                column: '__handle',
                formatted: static fn () => Icon::make('bars-4'),
            )->customWrapperAttributes(['class' => 'handle', 'style' => 'cursor: move']),
            ID::make(),
            Text::make('Name', 'name'),
            Text::make('Price', 'price'),
            Switcher::make('Active', 'is_active'),
        ];
    }

    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component->reorderable(
            $this->getResource()->getAsyncMethodUrl('reorder'),
        );
    }
}
