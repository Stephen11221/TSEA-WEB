<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institution_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_label')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('outcomes_title')->nullable();
            $table->string('trend_title')->nullable();
            $table->string('benefits_title')->nullable();
            $table->json('metrics')->nullable();
            $table->json('trend_items')->nullable();
            $table->json('benefits')->nullable();
            $table->json('institutions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institution_pages');
    }
};
