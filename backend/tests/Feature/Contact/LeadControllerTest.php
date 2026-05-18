<?php

declare(strict_types=1);

namespace Tests\Feature\Contact;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Modules\Services\Database\Factories\ServiceFactory;
use Tests\TestCase;

class LeadControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
        Mail::fake();
    }

    public function test_store_returns_json_success(): void
    {
        $this->postJson('/leads', ['email' => 'lead@example.com'])
            ->assertOk()
            ->assertJson(['success' => true]);
    }

    public function test_store_creates_lead_in_database(): void
    {
        $this->postJson('/leads', ['email' => 'stored@example.com']);

        $this->assertDatabaseHas('contact_leads', ['email' => 'stored@example.com']);
    }

    public function test_store_fails_when_email_is_missing(): void
    {
        $this->postJson('/leads', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('email');
    }

    public function test_store_fails_when_email_is_invalid(): void
    {
        $this->postJson('/leads', ['email' => 'not-an-email'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('email');
    }

    public function test_store_fails_when_phone_has_invalid_characters(): void
    {
        $this->postJson('/leads', [
            'email' => 'lead@example.com',
            'phone' => 'call me maybe',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('phone');
    }

    public function test_store_accepts_valid_phone_number(): void
    {
        $this->postJson('/leads', [
            'email'              => 'lead@example.com',
            'phone'              => '999 123 45 67',
            'phone_country_code' => '+7',
        ])->assertOk();
    }

    public function test_store_accepts_valid_service_id(): void
    {
        $service = ServiceFactory::new()->withTranslation('ru')->create();

        $this->postJson('/leads', [
            'email'      => 'lead@example.com',
            'service_id' => $service->id,
        ])->assertOk();

        $this->assertDatabaseHas('contact_leads', [
            'email'      => 'lead@example.com',
            'service_id' => $service->id,
        ]);
    }

    public function test_store_fails_when_service_id_does_not_exist(): void
    {
        $this->postJson('/leads', [
            'email'      => 'lead@example.com',
            'service_id' => 99999,
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('service_id');
    }

    public function test_store_saves_current_locale(): void
    {
        $this->postJson('/leads', ['email' => 'locale@example.com']);

        $this->assertDatabaseHas('contact_leads', [
            'email'  => 'locale@example.com',
            'locale' => 'ru',
        ]);
    }
}
