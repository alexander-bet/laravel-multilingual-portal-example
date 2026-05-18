<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Setting\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use App\MoonShine\Resources\Setting\SettingResource;

/**
 * @extends FormPage<SettingResource>
 */
class SettingFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            // ── Phones ───────────────────────────────────────────────────────
            Box::make('Phone numbers', [
                Json::make('Phones', 'phones')
                    ->fields([
                        Text::make('Number', 'number')
                            ->placeholder('+7 999 123-45-67'),
                        Text::make('Label', 'label')
                            ->placeholder('Moscow office'),
                    ])
                    ->creatable()
                    ->removable(),
            ]),

            // ── Emails ───────────────────────────────────────────────────────
            Box::make('Email addresses', [
                Json::make('Emails', 'emails')
                    ->fields([
                        Text::make('Email', 'email')
                            ->placeholder('info@example.com'),
                        Text::make('Label', 'label')
                            ->placeholder('General enquiries'),
                    ])
                    ->creatable()
                    ->removable(),
            ]),

            // ── Social media ─────────────────────────────────────────────────
            Box::make('Social media', [
                Json::make('Social links', 'social_links')
                    ->fields([
                        Text::make('Platform', 'platform')
                            ->placeholder('telegram'),
                        Text::make('URL', 'url')
                            ->placeholder('https://t.me/channel'),
                        Text::make('Label', 'label')
                            ->placeholder('Telegram'),
                    ])
                    ->creatable()
                    ->removable(),
            ]),

            // ── Addresses ────────────────────────────────────────────────────
            // is_main flag marks the headquarters; labels like "Main office" /
            // "Главный офис" are defined in lang files, not stored in data.
            Box::make('Addresses', [
                Json::make('Addresses', 'addresses')
                    ->fields([
                        Switcher::make('Main office', 'is_main'),
                        Text::make('Address (RU)', 'address')
                            ->placeholder('Москва, ул. Ленина, 1')
                            ->required(),
                        Text::make('Address (EN)', 'address_en')
                            ->placeholder('Moscow, Lenina st. 1'),
                        Text::make('Latitude', 'lat')
                            ->placeholder('55.751244')
                            ->required(),
                        Text::make('Longitude', 'lng')
                            ->placeholder('37.618423')
                            ->required(),
                    ])
                    ->creatable()
                    ->removable(),
            ]),

            // ── SMTP ─────────────────────────────────────────────────────────
            // Fields use smtp_* names, mapped to sub-keys of the smtp JSON
            // column via virtual accessors in Setting::getAttribute/setAttribute.
            // Leave all fields empty to keep using the .env mailer (Resend).
            Box::make('SMTP mail settings', [
                Text::make('Host', 'smtp_host')
                    ->placeholder('smtp.example.com')
                    ->hint('Leave blank to use the default mailer from .env'),
                Number::make('Port', 'smtp_port')
                    ->placeholder('587')
                    ->min(1)->max(65535),
                Select::make('Encryption', 'smtp_encryption')
                    ->options([
                        'tls'  => 'TLS (STARTTLS, port 587)',
                        'ssl'  => 'SSL (port 465)',
                        'none' => 'None (port 25)',
                    ])
                    ->nullable()
                    ->placeholder('— select —'),
                Text::make('Username', 'smtp_username')
                    ->placeholder('user@example.com'),
                Password::make('Password', 'smtp_password')
                    ->eye(),
                // Use Text (type=password) so MoonShine does NOT bcrypt the value.
                // Encryption is handled by Setting::setAttribute('smtp_password', ...).
                Text::make('Password', 'smtp_password')
                    ->type('password')
                    ->placeholder('••••••••')
                    ->hint('Leave blank to keep the current password')
                    ->onApply(function ($item, $value) {
                        if ($value !== '' && $value !== null) {
                            $item->smtp_password = $value;
                        }
                        return $item;
                    }),
                Text::make('From address', 'smtp_from_address')
                    ->placeholder('noreply@example.com'),
                Text::make('From name', 'smtp_from_name')
                    ->placeholder('Your Service Site'),
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
