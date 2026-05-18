<?php

declare(strict_types=1);

namespace Modules\Contact\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Contact\Models\Lead;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'email'  => fake()->safeEmail(),
            'locale' => 'ru',
            'source' => 'website',
            'ip'     => fake()->ipv4(),
        ];
    }
}
