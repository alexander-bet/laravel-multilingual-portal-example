<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Article\Pages;

use Modules\Blog\Models\Category;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use VI\MoonShineSpatieMediaLibrary\Fields\MediaLibrary;
use Sckatik\MoonshineEditorJs\Fields\EditorJs;
use App\MoonShine\Resources\Article\ArticleResource;

/**
 * @extends FormPage<ArticleResource>
 */
class ArticleFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        $categoryOptions = Category::with('translations')
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        return [
            Box::make([
                Select::make('Category', 'category_id')
                    ->options($categoryOptions)
                    ->nullable()
                    ->placeholder('— No category —'),
                Select::make('Status', 'status')
                    ->options(['draft' => 'Draft', 'published' => 'Published'])
                    ->default('draft')
                    ->required(),
                Date::make('Published at', 'published_at')
                    ->format('Y-m-d')
                    ->nullable(),
                MediaLibrary::make('Featured Image', 'featured'),
            ]),

            Box::make([
                Text::make('Title', 'title')->required(),
                Slug::make('Slug', 'slug')->from('title'),
                Textarea::make('Excerpt', 'excerpt')
                    ->customAttributes(['rows' => 3]),
                EditorJs::make('Content', 'content'),
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
