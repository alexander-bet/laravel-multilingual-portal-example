<?php

declare(strict_types=1);

namespace Modules\Core\Traits;

/**
 * Allows MoonShine admin fields to access translatable attributes
 * via locale-prefixed keys: ru_title, en_slug, zh_content, etc.
 *
 * Requires the consuming model to resolve the method collision with
 * Astrotomic\Translatable\Translatable by aliasing its getAttribute/setAttribute:
 *
 *   use Translatable, HasTranslatableAdminAttributes {
 *       HasTranslatableAdminAttributes::getAttribute insteadof Translatable;
 *       HasTranslatableAdminAttributes::setAttribute insteadof Translatable;
 *       Translatable::getAttribute as translatableGetAttribute;
 *       Translatable::setAttribute as translatableSetAttribute;
 *   }
 */
trait HasTranslatableAdminAttributes
{
    private const ADMIN_LOCALES = ['ru', 'en', 'ar', 'fa', 'tr', 'pt', 'es'];

    public function getAttribute($key): mixed
    {
        [$locale, $attr] = $this->parseTranslatableAdminKey($key);

        if ($locale !== null) {
            return $this->translate($locale)?->{$attr};
        }

        // Delegate to Translatable::getAttribute (aliased by the consuming model)
        return $this->translatableGetAttribute($key);
    }

    public function setAttribute($key, $value): static
    {
        [$locale, $attr] = $this->parseTranslatableAdminKey($key);

        if ($locale !== null) {
            // If the value is empty and no translation exists yet, skip creating
            // a bare skeleton record — it would fail NOT NULL constraints (e.g. slug).
            // Existing translations are always updated regardless of value.
            $isEmpty = $value === null || $value === '';

            if ($isEmpty && $this->getTranslation($locale, false) === null) {
                return $this;
            }

            $this->translateOrNew($locale)->{$attr} = $value;
            return $this;
        }

        // Delegate to Translatable::setAttribute (aliased by the consuming model)
        return $this->translatableSetAttribute($key, $value);
    }

    public function getFillable(): array
    {
        $base = parent::getFillable();

        $localePrefixed = [];
        foreach (self::ADMIN_LOCALES as $locale) {
            foreach ($this->translatedAttributes ?? [] as $attr) {
                $localePrefixed[] = $locale . '_' . $attr;
            }
        }

        return array_merge($base, $localePrefixed);
    }

    public function isFillable($key): bool
    {
        [$locale] = $this->parseTranslatableAdminKey($key);

        if ($locale !== null) {
            return true;
        }

        return parent::isFillable($key);
    }

    /** @return array{0: string|null, 1: string|null} */
    private function parseTranslatableAdminKey(string $key): array
    {
        foreach (self::ADMIN_LOCALES as $locale) {
            $prefix = $locale . '_';
            if (str_starts_with($key, $prefix)) {
                $attr = substr($key, \strlen($prefix));
                if (in_array($attr, $this->translatedAttributes ?? [], true)) {
                    return [$locale, $attr];
                }
            }
        }

        return [null, null];
    }
}
