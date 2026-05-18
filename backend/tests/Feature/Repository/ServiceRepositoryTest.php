<?php

declare(strict_types=1);

namespace Tests\Feature\Repository;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Services\Database\Factories\ServiceFactory;
use Modules\Services\Repositories\ServiceRepository;
use Tests\TestCase;

class ServiceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ServiceRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(ServiceRepository::class);
    }

    // ── getAll ────────────────────────────────────────────────────────────────

    public function test_get_all_returns_published_services(): void
    {
        ServiceFactory::new()->withTranslation('ru')->count(3)->create();

        $result = $this->repository->getAll();

        $this->assertCount(3, $result);
    }

    public function test_get_all_excludes_draft_services(): void
    {
        ServiceFactory::new()->withTranslation('ru')->create();
        ServiceFactory::new()->draft()->withTranslation('ru')->create();

        $result = $this->repository->getAll();

        $this->assertCount(1, $result);
    }

    public function test_get_all_excludes_services_without_locale_translation(): void
    {
        ServiceFactory::new()->withTranslation('ru')->create();
        ServiceFactory::new()->withTranslation('en')->create();

        app()->setLocale('ru');

        $result = $this->repository->getAll();

        $this->assertCount(1, $result);
    }

    public function test_get_all_orders_by_sort_order(): void
    {
        $last  = ServiceFactory::new()->state(['sort_order' => 99])->withTranslation('ru')->create();
        $first = ServiceFactory::new()->state(['sort_order' => 1])->withTranslation('ru')->create();

        $result = $this->repository->getAll();

        $this->assertEquals($first->id, $result->first()->id);
        $this->assertEquals($last->id, $result->last()->id);
    }

    // ── getFeatured ───────────────────────────────────────────────────────────

    public function test_get_featured_returns_only_featured_published_services(): void
    {
        ServiceFactory::new()->featured()->withTranslation('ru')->count(2)->create();
        ServiceFactory::new()->withTranslation('ru')->create(); // not featured

        $result = $this->repository->getFeatured();

        $this->assertCount(2, $result);
        $this->assertTrue($result->every(fn ($s) => $s->featured === true));
    }

    public function test_get_featured_excludes_draft_services(): void
    {
        ServiceFactory::new()->featured()->withTranslation('ru')->create();
        ServiceFactory::new()->featured()->draft()->withTranslation('ru')->create();

        $result = $this->repository->getFeatured();

        $this->assertCount(1, $result);
    }

    public function test_get_featured_returns_empty_when_no_featured_services(): void
    {
        ServiceFactory::new()->withTranslation('ru')->count(3)->create();

        $result = $this->repository->getFeatured();

        $this->assertCount(0, $result);
    }
}
