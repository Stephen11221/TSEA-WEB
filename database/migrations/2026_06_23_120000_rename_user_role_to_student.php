<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL enum must allow target value before data update.
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'employer', 'user', 'student', 'instructor') DEFAULT 'student'");
        }

        DB::table('users')->where('role', 'user')->update(['role' => 'student']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'employer', 'student', 'instructor') DEFAULT 'student'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'employer', 'user', 'student', 'instructor') DEFAULT 'user'");
        }

        DB::table('users')->where('role', 'student')->update(['role' => 'user']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'employer', 'user', 'instructor') DEFAULT 'user'");
        }
    }
};
