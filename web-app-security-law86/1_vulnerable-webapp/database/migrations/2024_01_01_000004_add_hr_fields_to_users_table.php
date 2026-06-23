<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'department')) {
                $table->string('department')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'join_date')) {
                $table->date('join_date')->nullable()->after('department');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('Active')->after('join_date');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('status');
            }
        });

        // Modify the role column from ENUM to VARCHAR to allow custom roles like 'engineer', 'design', etc.
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) DEFAULT 'user'");
        } catch (\Exception $e) {
            // Fallback for non-MySQL databases
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['department', 'join_date', 'status', 'avatar']);
        });
    }
};
