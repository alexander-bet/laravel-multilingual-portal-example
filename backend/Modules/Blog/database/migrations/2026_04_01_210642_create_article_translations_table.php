<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 10)->index();
            $table->string('slug')->index();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->jsonb('content')->nullable(); // Editor.js JSON
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->unique(['article_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_translations');
    }
};
