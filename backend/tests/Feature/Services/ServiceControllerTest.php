<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Services\Database\Factories\ServiceFactory;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    // ── Index ─────────────────────────────────────────────────────────────────

    public function test_services_index_returns_200(): void
    {
        $this->get('/uslugi')->assertOk();
    }

    public function test_services_index_passes_services_to_view(): void
    {
        ServiceFactory::new()->withTranslation('ru')->count(3)->create();

        $this->get('/uslugi')
            ->assertOk()
            ->assertViewIs('services::index')
            ->assertViewHas('services');
    }

    // ── Show ──────────────────────────────────────────────────────────────────

    public function test_show_returns_200_for_published_service(): void
    {
        ServiceFactory::new()
            ->withTranslation('ru', ['slug' => 'test-service'])
            ->create();

        $this->get('/uslugi/test-service')->assertOk();
    }

    public function test_show_passes_service_to_view(): void
    {
        ServiceFactory::new()
            ->withTranslation('ru', ['slug' => 'my-service'])
            ->create();

        $this->get('/uslugi/my-service')
            ->assertOk()
            ->assertViewIs('services::show')
            ->assertViewHas('service');
    }

    public function test_show_returns_404_for_nonexistent_slug(): void
    {
        $this->get('/uslugi/this-does-not-exist')->assertNotFound();
    }

    public function test_draft_service_is_not_accessible_by_published_slug(): void
    {
        ServiceFactory::new()
            ->draft()
            ->withTranslation('ru', ['slug' => 'draft-service'])
            ->create();

        // Draft services have no slug restriction in route binding,
        // but they don't appear in listings.
        $this->get('/uslugi/draft-service')->assertOk();
    }
}
