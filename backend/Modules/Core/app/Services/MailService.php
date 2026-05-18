<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use Modules\Core\Models\Setting;

/**
 * Thin helper that exposes the application mailer and common mail meta.
 *
 * SMTP configuration (host, port, credentials) is applied once at boot by
 * AppServiceProvider::configureSmtp(), so all calls to Mail::mailer() already
 * use the admin-configured SMTP when it is set up.
 */
class MailService
{
    /**
     * Returns the default application mailer (already configured at boot).
     */
    public static function mailer(): Mailer
    {
        return Mail::mailer();
    }

    /**
     * Returns the "from" address for outgoing mail.
     * At boot, configureSmtp() may have overridden mail.from.address from DB.
     */
    public static function fromAddress(): string
    {
        return (string) config('mail.from.address');
    }

    /**
     * Returns the "from" name for outgoing mail.
     */
    public static function fromName(): string
    {
        return (string) config('mail.from.name');
    }

    /**
     * Returns the first admin notification email from Settings emails list, or null.
     */
    public static function notifyEmail(): ?string
    {
        $emails = Setting::instance()->emails ?? [];
        return ($emails[0]['email'] ?? null) ?: null;
    }
}
