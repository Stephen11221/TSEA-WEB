<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();

            $table->string('hero_label')->nullable();
            $table->text('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_tagline')->nullable();

            $table->string('mission_title')->nullable();
            $table->text('mission_description')->nullable();

            $table->string('infrastructure_title')->nullable();
            $table->text('infrastructure_description')->nullable();

            $table->string('impact_title')->nullable();
            $table->text('impact_description')->nullable();

            $table->string('hero_image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};