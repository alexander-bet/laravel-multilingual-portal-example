<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Category\Pages;

use Modules\Blog\Models\Category;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use VI\MoonShineSpatieMediaLibrary\Fields\MediaLibrary;
use App\MoonShine\Resources\Category\CategoryResource;

/**
 * @extends FormPage<CategoryResource>
 */
class CategoryFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        $parentOptions = Category::with('translations')
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        return [
            Box::make([
                Select::make('Parent category', 'parent_id')
                    ->options($parentOptions)
                    ->nullable()
                    ->placeholder('— No parent —'),
                Number::make('Sort order', 'sort_order')
                    ->default(0),
                MediaLibrary::make('Cover Image', 'cover'),
            ]),

            Box::make([
                Text::make('Name', 'name')->required(),
                Slug::make('Slug', 'slug')->from('name'),
                Textarea::make('Description', 'description')
                    ->customAttributes(['rows' => 3]),
                Text::make('Meta Title', 'meta_title'),
                Textarea::make('Meta Description', 'meta_description')
                    ->customAttributes(['rows' => 3]),
            ]),
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
