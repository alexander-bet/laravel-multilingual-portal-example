<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('media')
            ->where('model_type', 'Modules\Services\Models\Service')
            ->where('collection_name', 'featured')
            ->update(['collection_name' => 'cover']);
    }

    public function down(): void
    {
        DB::table('media')
            ->where('model_type', 'Modules\Services\Models\Service')
            ->where('collection_name', 'cover')
            ->update(['collection_name' => 'featured']);
    }
};
