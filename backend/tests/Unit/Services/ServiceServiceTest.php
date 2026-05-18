<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Services\Repositories\ServiceRepository;
use Modules\Services\Services\ServiceService;
use Tests\TestCase;

class ServiceServiceTest extends TestCase
{
    private ServiceService $service;
    private ServiceRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createMock(ServiceRepository::class);
        $this->service    = new ServiceService($this->repository);
    }

    public function test_list_services_delegates_to_repository(): void
    {
        $collection = new Collection();

        $this->repository
            ->expects($this->once())
            ->method('getAll')
            ->willReturn($collection);

        $result = $this->service->listServices();

        $this->assertSame($collection, $result);
    }

    public function test_get_featured_services_delegates_to_repository(): void
    {
        $collection = new Collection();

        $this->repository
            ->expects($this->once())
            ->method('getFeatured')
            ->willReturn($collection);

        $result = $this->service->getFeaturedServices();

        $this->assertSame($collection, $result);
    }
}
