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
    Schema::create('eri_pages', function (Blueprint $table) {
        $table->id();

        // Hero
        $table->string('hero_eyebrow')->nullable();
        $table->string('hero_title')->nullable();
        $table->text('hero_description')->nullable();

        // Score
        $table->integer('eri_score')->default(0);
        $table->string('score_label')->nullable();
        $table->text('score_message')->nullable();

        // Competency JSON (flexible)
        $table->json('competencies')->nullable(); 
        // example: [{label:"Communication", value:75}]

        // Recommendations
        $table->json('recommendations')->nullable();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eri_pages');
    }
};
