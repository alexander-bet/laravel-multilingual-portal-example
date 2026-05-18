<?php

declare(strict_types=1);

namespace Modules\Contact\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Contact\Models\Lead;
use Modules\Core\Services\MailService;

class LeadReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Lead $lead) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(
                MailService::fromAddress(),
                MailService::fromName(),
            ),
            subject: 'Новая заявка с сайта ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'contact::mail.lead-received',
        );
    }
}
