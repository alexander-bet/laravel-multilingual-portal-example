<?php

declare(strict_types=1);

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Blog\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

    public function withTranslation(string $locale = 'ru', array $overrides = []): static
    {
        return $this->afterCreating(function (Category $category) use ($locale, $overrides) {
            $category->translateOrNew($locale)->fill(array_merge([
                'slug' => fake()->unique()->slug(),
                'name' => fake()->words(2, true),
            ], $overrides))->save();
        });
    }
}
