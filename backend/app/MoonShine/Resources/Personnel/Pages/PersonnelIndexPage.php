<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Personnel\Pages;

use App\MoonShine\Resources\Personnel\PersonnelResource;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Components\Icon;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Text;
use VI\MoonShineSpatieMediaLibrary\Fields\MediaLibrary;

/**
 * @extends IndexPage<PersonnelResource>
 */
class PersonnelIndexPage extends IndexPage
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
            MediaLibrary::make('Photo', 'photo'),
            Text::make('Name', 'name'),
            Text::make('Position', 'position'),
        ];
    }

    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component->reorderable(
            $this->getResource()->getAsyncMethodUrl('reorder'),
        );
    }
}
