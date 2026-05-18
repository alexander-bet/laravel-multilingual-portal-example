<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personnel', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('personnel_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnel')->cascadeOnDelete();
            $table->string('locale', 10)->index();
            $table->string('name');
            $table->string('position');

            $table->unique(['personnel_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnel_translations');
        Schema::dropIfExists('personnel');
    }
};
