<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('price', 50);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('pricing_plan_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pricing_plan_id')->constrained('pricing_plans')->cascadeOnDelete();
            $table->string('locale', 10)->index();
            $table->string('name');
            $table->text('features')->nullable();

            $table->unique(['pricing_plan_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_plan_translations');
        Schema::dropIfExists('pricing_plans');
    }
};
