<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Service\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\Service\ServiceResource;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Text;
use VI\MoonShineSpatieMediaLibrary\Fields\MediaLibrary;
use Sckatik\MoonshineEditorJs\Fields\EditorJs;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Textarea;
use Throwable;


/**
 * @extends FormPage<ServiceResource>
 */
class ServiceFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Text::make('Title')->required(),
            Select::make('Status', 'status')
                ->options(['draft' => 'Draft', 'published' => 'Published'])
                ->default('draft')
                ->required(),
            Switcher::make('Featured on homepage', 'featured'),
            Textarea::make('Icon SVG', 'icon')
                ->hint('Paste inline SVG code (e.g. <svg ...>...</svg>)')
                ->customAttributes(['rows' => 4, 'placeholder' => '<svg xmlns="http://www.w3.org/2000/svg" ...>...</svg>']),
            MediaLibrary::make('Cover Image', 'cover'),
            EditorJs::make('Content', 'content')->required(),
            Textarea::make('Excerpt', 'excerpt'),
            Box::make([
                Tabs::make([
                    Tab::make('SEO', [
                    Slug::make('Slug')
                    ->from('Title')
                    ->required(),
                    Text::make('Meta Title', 'meta_title')
                        ->required(),
                    Textarea::make('Meta Description', 'meta_description')
                        ->required()
                        ->customAttributes([
                            'rows' => 3,
                        ]),

                    ]),

                    Tab::make('Additional', [
                            Date::make(__('moonshine::ui.resource.created_at'), 'created_at')
                            ->format("d.m.Y")
                            ->default(now()->toDateTimeString()),
                            Date::make('Updated at', 'updated_at')
                            ->format("d.m.Y")
                            ->default(now()->toDateTimeString()),
                    ]),
                ]),
            ]),
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    protected function formButtons(): ListOf
    {
        return parent::formButtons();
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [];
    }

    /**
     * @param  FormBuilder  $component
     *
     * @return FormBuilder
     */
    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}
