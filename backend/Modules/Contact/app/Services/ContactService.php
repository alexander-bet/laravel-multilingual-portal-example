<?php

declare(strict_types=1);

namespace Modules\Contact\Services;

use Illuminate\Support\Facades\Log;
use Modules\Contact\Http\Requests\ContactFormRequest;

class ContactService
{
    public function handle(ContactFormRequest $request): void
    {
        $data = $request->validated();

        // TODO: send email via Resend + Telegram notification
        // Mail::to(config('contact.recipient'))->send(new ContactMail($data));
        // Telegram::sendMessage($data);

        Log::info('Contact form submission', $data);
    }
}
