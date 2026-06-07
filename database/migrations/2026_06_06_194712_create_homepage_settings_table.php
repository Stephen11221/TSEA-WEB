<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('homepage_settings', function (Blueprint $table) {
    $table->id();

    $table->string('hero_eyebrow')->nullable();
    $table->string('hero_title')->nullable();
    $table->text('hero_description')->nullable();

    $table->string('primary_button_text')->nullable();
    $table->string('primary_button_link')->nullable();

    $table->string('secondary_button_text')->nullable();
    $table->string('secondary_button_link')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
    }
};
