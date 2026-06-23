<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Demo credentials table - stores all access info for educational purposes
     * Accessible via phpMyAdmin at localhost:8080
     */
    public function up(): void
    {
        Schema::create('demo_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('service');           // e.g. "Vulnerable App", "SonarQube"
            $table->string('url');               // Access URL
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('role')->nullable();  // admin, user, etc.
            $table->text('notes')->nullable();   // Extra info / vulnerability notes
            $table->timestamps();
        });

        Schema::create('service_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Link name
            $table->string('url');               // Full URL
            $table->string('category');          // app, admin, tool, vulnerability
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demo_credentials');
        Schema::dropIfExists('service_links');
    }
};
