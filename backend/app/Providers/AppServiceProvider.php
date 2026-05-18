<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Controllers\EditorJsImageUploadController;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Models\Setting;
use Sckatik\MoonshineEditorJs\Http\Controllers\EditorJsImageController;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Replace EditorJS image controller with our WebP-converting version
        $this->app->bind(EditorJsImageController::class, EditorJsImageUploadController::class);
    }

    public function boot(): void
    {
        $this->configureSmtp();
    }

    /**
     * Override Laravel's mail config at runtime using SMTP settings stored in
     * the database. Runs on every request but reads from cache (1 hour TTL),
     * so there's no DB hit per request after the first one.
     *
     * Cache is automatically cleared when Settings are saved (Setting::booted).
     *
     * If the smtp.host field is empty, the .env mailer (e.g. Resend) is used
     * unchanged — this lets you keep Resend as the default and only switch to
     * SMTP when explicitly configured in the admin panel.
     */
    private function configureSmtp(): void
    {
        try {
            // Cache only non-sensitive fields (never cache the decrypted password)
            $smtp = Cache::remember('settings.smtp', 3600, function () {
                $raw = Setting::where('id', 1)->value('smtp');
                return $raw ? (is_array($raw) ? $raw : json_decode($raw, true)) : [];
            });

            if (empty($smtp['host']) || empty($smtp['username'])) {
                return;
            }

            // Decrypt the password — it is stored via Crypt::encryptString()
            $encryptedPassword = $smtp['password'] ?? null;

            if (! $encryptedPassword) {
                return;
            }

            try {
                $password = Crypt::decryptString($encryptedPassword);
            } catch (DecryptException) {
                // Password was stored in an old/invalid format — skip SMTP override
                return;
            }

            // 'tls' = STARTTLS (port 587), 'ssl' = SSL/TLS (port 465), null = plain
            $encryption = match ($smtp['encryption'] ?? null) {
                'ssl'  => 'ssl',
                'tls'  => 'tls',
                default => null,  // 'none' or unset → no encryption
            };

            config([
                'mail.default'                 => 'smtp',
                'mail.mailers.smtp.host'       => $smtp['host'],
                'mail.mailers.smtp.port'       => (int) ($smtp['port'] ?? 587),
                'mail.mailers.smtp.encryption' => $encryption,
                'mail.mailers.smtp.username'   => $smtp['username'],
                'mail.mailers.smtp.password'   => $password,
                'mail.from.address'            => $smtp['from_address'] ?? config('mail.from.address'),
                'mail.from.name'               => $smtp['from_name']    ?? config('mail.from.name'),
            ]);
        } catch (Throwable) {
            // Silently skip if the settings table doesn't exist yet
            // (e.g. during php artisan migrate on a fresh install)
        }
    }
}
