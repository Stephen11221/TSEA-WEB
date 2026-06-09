<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('homepage_settings', 'content')) {
                $table->json('content')->nullable()->after('secondary_button_link');
            }
        });
    }

    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            if (Schema::hasColumn('homepage_settings', 'content')) {
                $table->dropColumn('content');
            }
        });
    }
};
