<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('email', 150);
            $table->string('phone', 30)->nullable();
            $table->string('phone_country_code', 10)->nullable();
            $table->string('locale', 10)->default('ru');
            $table->string('source', 50)->default('unknown');
            $table->enum('status', ['new', 'in_progress', 'closed'])->default('new');
            $table->string('ip', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_leads');
    }
};
