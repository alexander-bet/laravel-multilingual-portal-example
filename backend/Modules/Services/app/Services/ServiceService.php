<?php

declare(strict_types=1);

namespace Modules\Services\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Services\Repositories\ServiceRepository;

class ServiceService
{
    public function __construct(
        private readonly ServiceRepository $repository,
    ) {}

    public function getFeaturedServices(): Collection
    {
        return $this->repository->getFeatured();
    }

    public function listServices(): Collection
    {
        return $this->repository->getAll();
    }
}
