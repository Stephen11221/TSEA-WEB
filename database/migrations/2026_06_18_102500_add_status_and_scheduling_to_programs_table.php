<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $blueprint) {
            if (!Schema::hasColumn('programs', 'status')) {
                $blueprint->string('status')->default('inactive')->after('description');
            }
            // 'category' and 'level' columns are already defined in 2026_06_11_022725_create_programs_table.php
            // No need to add them again here.
            
            if (!Schema::hasColumn('programs', 'scheduled_activation_at')) {
                $blueprint->timestamp('scheduled_activation_at')->nullable()->after('level');
            }
            if (!Schema::hasColumn('programs', 'scheduled_deactivation_at')) {
                $blueprint->timestamp('scheduled_deactivation_at')->nullable()->after('scheduled_activation_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['status', 'scheduled_activation_at', 'scheduled_deactivation_at']);
        });
    }
};