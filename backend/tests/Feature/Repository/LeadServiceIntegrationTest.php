<?php

declare(strict_types=1);

namespace Tests\Feature\Repository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Modules\Contact\Mail\LeadReceivedMail;
use Modules\Contact\Models\Lead;
use Modules\Contact\Services\LeadService;
use Modules\Core\Models\Setting;
use Tests\TestCase;

class LeadServiceIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private LeadService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(LeadService::class);
        Mail::fake();
    }

    public function test_store_creates_lead_in_database(): void
    {
        $this->service->store(['email' => 'test@example.com'], '127.0.0.1');

        $this->assertDatabaseHas('contact_leads', ['email' => 'test@example.com']);
    }

    public function test_store_returns_lead_model(): void
    {
        $lead = $this->service->store(['email' => 'test@example.com'], '127.0.0.1');

        $this->assertInstanceOf(Lead::class, $lead);
        $this->assertEquals('test@example.com', $lead->email);
    }

    public function test_store_saves_current_locale(): void
    {
        app()->setLocale('en');

        $this->service->store(['email' => 'en@example.com'], '127.0.0.1');

        $this->assertDatabaseHas('contact_leads', [
            'email'  => 'en@example.com',
            'locale' => 'en',
        ]);
    }

    public function test_store_saves_ip_address(): void
    {
        $this->service->store(['email' => 'ip@example.com'], '192.168.1.100');

        $this->assertDatabaseHas('contact_leads', [
            'email' => 'ip@example.com',
            'ip'    => '192.168.1.100',
        ]);
    }

    public function test_store_saves_optional_fields(): void
    {
        $this->service->store([
            'email'              => 'full@example.com',
            'phone'              => '123456789',
            'phone_country_code' => '+7',
            'source'             => 'homepage',
        ], '127.0.0.1');

        $this->assertDatabaseHas('contact_leads', [
            'email'              => 'full@example.com',
            'phone'              => '123456789',
            'phone_country_code' => '+7',
            'source'             => 'homepage',
        ]);
    }

    public function test_store_sends_email_when_notify_address_is_configured(): void
    {
        Setting::instance()->update(['emails' => [['email' => 'admin@example.com']]]);

        $this->service->store(['email' => 'lead@example.com'], '127.0.0.1');

        Mail::assertSent(LeadReceivedMail::class);
    }

    public function test_store_skips_email_when_no_notify_address_configured(): void
    {
        $this->service->store(['email' => 'lead@example.com'], '127.0.0.1');

        Mail::assertNothingSent();
    }
}
