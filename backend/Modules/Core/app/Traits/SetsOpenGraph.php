<?php

declare(strict_types=1);

namespace Modules\Core\Traits;

use Butschster\Head\Facades\Meta;
use Butschster\Head\MetaTags\Entities\Tag;

trait SetsOpenGraph
{
    /**
     * Set OG tags for a static page (index pages, home, contact).
     */
    protected function setStaticOg(string $title, string $description, ?string $imageUrl = null): void
    {
        $this->applyOgTags('website', $title, $description, $imageUrl);
    }

    /**
     * Set OG tags for a model detail page (article, service, category show).
     */
    protected function setModelOg(
        string $title,
        string $description,
        ?string $imageUrl = null,
        string $type = 'article',
    ): void {
        $this->applyOgTags($type, $title, $description, $imageUrl);
    }

    private function applyOgTags(string $type, string $title, string $description, ?string $imageUrl): void
    {
        $tags = [
            'og:type'        => ['property' => 'og:type',        'content' => $type],
            'og:site_name'   => ['property' => 'og:site_name',   'content' => config('app.name')],
            'og:title'       => ['property' => 'og:title',       'content' => $title],
            'og:description' => ['property' => 'og:description', 'content' => $description],
            'og:url'         => ['property' => 'og:url',         'content' => request()->url()],
            'og:locale'      => ['property' => 'og:locale',      'content' => $this->ogLocale()],
        ];

        if ($imageUrl) {
            $tags['og:image']     = ['property' => 'og:image',     'content' => $imageUrl];
            $tags['og:image:alt'] = ['property' => 'og:image:alt', 'content' => $title];
        }

        foreach ($tags as $name => $attributes) {
            Meta::addTag($name, Tag::meta($attributes));
        }
    }

    /**
     * Convert Laravel locale to OG locale format (language_TERRITORY).
     */
    private function ogLocale(): string
    {
        return match (app()->getLocale()) {
            'ar'    => 'ar_SA',
            'fa'    => 'fa_IR',
            'tr'    => 'tr_TR',
            'pt'    => 'pt_PT',
            'es'    => 'es_ES',
            'en'    => 'en_US',
            default => 'ru_RU',
        };
    }
}
