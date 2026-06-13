<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workforce_passports', function (Blueprint $table) {
            $table->id();

            // Hero Section
            $table->string('hero_label')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('cta_text')->nullable();

            // Profile Section
            $table->string('profile_name')->nullable();
            $table->string('profile_location')->nullable();
            $table->integer('passport_score')->default(0);

            // Skills
            $table->string('skill_name_1')->nullable();
            $table->integer('skill_score_1')->nullable();

            $table->string('skill_name_2')->nullable();
            $table->integer('skill_score_2')->nullable();

            $table->string('skill_name_3')->nullable();
            $table->integer('skill_score_3')->nullable();

            $table->string('skill_name_4')->nullable();
            $table->integer('skill_score_4')->nullable();

            $table->string('skill_name_5')->nullable();
            $table->integer('skill_score_5')->nullable();

            // Credentials
            $table->text('credential_1')->nullable();
            $table->text('credential_2')->nullable();
            $table->text('credential_3')->nullable();
            $table->text('credential_4')->nullable();

            // Readiness Indicators
            $table->string('readiness_1')->nullable();
            $table->string('readiness_2')->nullable();
            $table->string('readiness_3')->nullable();

            // Benefits
            $table->string('benefit_1')->nullable();
            $table->string('benefit_2')->nullable();
            $table->string('benefit_3')->nullable();
            $table->string('benefit_4')->nullable();
            $table->string('benefit_5')->nullable();
            $table->string('benefit_6')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workforce_passports');
    }
};