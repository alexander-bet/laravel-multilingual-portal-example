<?php

declare(strict_types=1);

namespace Modules\Services\Database\Seeders;

use Illuminate\Database\Seeder;

class ServicesDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
        ]);
    }
}
