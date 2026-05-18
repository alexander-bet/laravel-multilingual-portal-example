<?php

declare(strict_types=1);

namespace Modules\Services\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Services\Models\Service;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'status'     => 'published',
            'featured'   => false,
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => 'draft']);
    }

    public function featured(): static
    {
        return $this->state(fn () => ['featured' => true]);
    }

    public function withTranslation(string $locale = 'ru', array $overrides = []): static
    {
        return $this->afterCreating(function (Service $service) use ($locale, $overrides) {
            $service->translateOrNew($locale)->fill(array_merge([
                'slug'    => fake()->unique()->slug(),
                'title'   => fake()->sentence(),
                'excerpt' => fake()->paragraph(),
            ], $overrides))->save();
        });
    }
}
