<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'program_id')) {
                $table->foreignId('program_id')
                    ->nullable()
                    ->after('job_posting_id')
                    ->constrained('programs')
                    ->cascadeOnDelete();
            }

            if (!Schema::hasColumn('applications', 'submitted_at')) {
                $table->dateTime('submitted_at')->nullable()->after('reviewed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            if (Schema::hasColumn('applications', 'program_id')) {
                $table->dropConstrainedForeignId('program_id');
            }

            if (Schema::hasColumn('applications', 'submitted_at')) {
                $table->dropColumn('submitted_at');
            }
        });
    }
};
