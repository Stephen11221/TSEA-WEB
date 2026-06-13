<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_passports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('passport_number')->unique();
            $table->json('skills')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('certifications')->nullable();
            $table->string('status')->default('draft'); // draft, submitted, approved, rejected
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('user_passports'); }
};