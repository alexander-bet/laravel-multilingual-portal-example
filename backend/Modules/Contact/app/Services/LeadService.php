<?php

declare(strict_types=1);

namespace Modules\Contact\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Contact\Mail\LeadReceivedMail;
use Modules\Contact\Models\Lead;
use Modules\Core\Services\MailService;

class LeadService
{
    public function store(array $data, string $ip): Lead
    {
        $lead = Lead::create([
            'service_id'         => $data['service_id'] ?? null,
            'email'              => $data['email'],
            'phone'              => $data['phone'] ?? null,
            'phone_country_code' => $data['phone_country_code'] ?? null,
            'locale'             => app()->getLocale(),
            'source'             => $data['source'] ?? 'unknown',
            'ip'                 => $ip,
        ]);

        // Email notification to admin
        $this->sendEmailNotification($lead);

        return $lead;
    }

    private function sendEmailNotification(Lead $lead): void
    {
        $to = MailService::notifyEmail();

        if (! $to) {
            Log::warning('Lead email notification skipped: no notification email configured in Settings.');
            return;
        }

        try {
            Mail::to($to)->send(new LeadReceivedMail($lead->load('service.translations')));
        } catch (\Throwable $e) {
            Log::error('Failed to send lead notification email.', [
                'lead_id' => $lead->id,
                'error'   => $e->getMessage(),
            ]);
        }
    }
}
