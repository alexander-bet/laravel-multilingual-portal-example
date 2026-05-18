<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->jsonb('phones')->nullable();       // [{number, label}]
            $table->jsonb('emails')->nullable();       // [{email, label}]
            $table->jsonb('social_links')->nullable(); // [{platform, url, label}]
            $table->jsonb('addresses')->nullable();    // [{title, address, lat, lng}]
            $table->jsonb('smtp')->nullable();         // {host, port, encryption, username, password, from_address, from_name}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
