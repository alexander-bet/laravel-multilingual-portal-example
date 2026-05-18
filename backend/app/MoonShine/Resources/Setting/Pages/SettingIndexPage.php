<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Setting\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\LineBreak;
use App\MoonShine\Resources\Setting\SettingResource;

/**
 * @extends IndexPage<SettingResource>
 */
class SettingIndexPage extends IndexPage
{
    /**
     * @return list<ComponentContract>
     */
    protected function mainLayer(): array
    {
        $editUrl = $this->getResource()->getFormPageUrl(1);

        return [
            Box::make([
                ActionButton::make('Edit Settings', $editUrl)
                    ->primary(),
            ]),
        ];
    }
}
