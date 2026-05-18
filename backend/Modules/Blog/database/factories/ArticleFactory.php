<?php

declare(strict_types=1);

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Blog\Models\Article;
use Modules\Blog\Models\Category;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'category_id'  => Category::factory(),
            'status'       => 'published',
            'published_at' => now()->subHour(),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status'       => 'draft',
            'published_at' => null,
        ]);
    }

    public function futurePublished(): static
    {
        return $this->state(fn () => [
            'published_at' => now()->addDay(),
        ]);
    }

    public function withTranslation(string $locale = 'ru', array $overrides = []): static
    {
        return $this->afterCreating(function (Article $article) use ($locale, $overrides) {
            $article->translateOrNew($locale)->fill(array_merge([
                'slug'    => fake()->unique()->slug(),
                'title'   => fake()->sentence(),
                'excerpt' => fake()->paragraph(),
            ], $overrides))->save();
        });
    }
}
