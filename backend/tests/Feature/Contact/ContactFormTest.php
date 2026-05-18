<?php

declare(strict_types=1);

namespace Tests\Feature\Contact;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_contact_page_returns_200(): void
    {
        $this->get('/contact')->assertOk();
    }

    public function test_store_redirects_to_contact_page_with_success_flag(): void
    {
        $this->post('/contact', $this->validPayload())
            ->assertRedirect(route('contact.index'))
            ->assertSessionHas('success', true);
    }

    public function test_store_fails_when_name_is_missing(): void
    {
        $this->post('/contact', array_merge($this->validPayload(), ['name' => '']))
            ->assertSessionHasErrors('name');
    }

    public function test_store_fails_when_email_is_missing(): void
    {
        $this->post('/contact', array_merge($this->validPayload(), ['email' => '']))
            ->assertSessionHasErrors('email');
    }

    public function test_store_fails_when_email_is_invalid(): void
    {
        $this->post('/contact', array_merge($this->validPayload(), ['email' => 'not-an-email']))
            ->assertSessionHasErrors('email');
    }

    public function test_store_fails_when_message_is_missing(): void
    {
        $this->post('/contact', array_merge($this->validPayload(), ['message' => '']))
            ->assertSessionHasErrors('message');
    }

    public function test_store_fails_when_message_is_too_short(): void
    {
        $this->post('/contact', array_merge($this->validPayload(), ['message' => 'Short']))
            ->assertSessionHasErrors('message');
    }

    public function test_store_fails_when_message_exceeds_max_length(): void
    {
        $this->post('/contact', array_merge($this->validPayload(), ['message' => str_repeat('a', 2001)]))
            ->assertSessionHasErrors('message');
    }

    public function test_store_accepts_optional_phone(): void
    {
        $payload = array_merge($this->validPayload(), ['phone' => '+7 999 123 45 67']);

        $this->post('/contact', $payload)
            ->assertRedirect(route('contact.index'));
    }

    public function test_store_succeeds_without_phone(): void
    {
        $payload = $this->validPayload();
        unset($payload['phone']);

        $this->post('/contact', $payload)
            ->assertRedirect(route('contact.index'));
    }

    private function validPayload(): array
    {
        return [
            'name'    => 'Ivan Petrov',
            'email'   => 'ivan@example.com',
            'phone'   => '+7 900 000 00 00',
            'message' => 'Hello, I would like to know more about your services in China.',
        ];
    }
}
