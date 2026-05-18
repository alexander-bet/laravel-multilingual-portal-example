<?php

declare(strict_types=1);

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Setting extends Model
{
    protected $fillable = [
        'phones',
        'emails',
        'social_links',
        'addresses',
        'smtp',
    ];

    protected $casts = [
        'phones'       => 'array',
        'emails'       => 'array',
        'social_links' => 'array',
        'addresses'    => 'array',
        'smtp'         => 'array',
    ];

    // ── Singleton ─────────────────────────────────────────────────────────────

    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1]);
    }

    public static function get(string $key): mixed
    {
        return static::instance()->{$key};
    }

    // ── Cache invalidation ────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.smtp'));
    }

    // ── Virtual smtp_* accessors ──────────────────────────────────────────────
    //
    // Allows MoonShine form fields named smtp_host, smtp_port, etc. to map
    // cleanly to sub-keys of the smtp JSON column, without a repeatable row UI.

    public function getAttribute($key): mixed
    {
        if (str_starts_with($key, 'smtp_')) {
            $field = substr($key, 5);
            $value = ($this->smtp ?? [])[$field] ?? null;

            // Decrypt password on read
            if ($field === 'password' && $value !== null) {
                try {
                    return Crypt::decryptString($value);
                } catch (DecryptException) {
                    // Value was stored before encryption was introduced — return as-is
                    return null;
                }
            }

            return $value;
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value): static
    {
        if (str_starts_with($key, 'smtp_')) {
            $field = substr($key, 5);
            $smtp  = $this->smtp ?? [];

            if ($value === '' || $value === null) {
                $smtp[$field] = null;
            } elseif ($field === 'password') {
                // Store password encrypted, not hashed
                $smtp[$field] = Crypt::encryptString($value);
            } else {
                $smtp[$field] = $value;
            }

            parent::setAttribute('smtp', $smtp);
            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    public function isFillable($key): bool
    {
        if (str_starts_with($key, 'smtp_')) {
            return true;
        }

        return parent::isFillable($key);
    }
}
