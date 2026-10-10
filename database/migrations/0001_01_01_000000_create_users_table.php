<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Users Table
 *
 * Extends the default Laravel users table with:
 * - google_id: for Google OAuth authentication via Socialite
 * - password nullable: Google OAuth users may not have a password
 * - phone, universitas, jurusan, alamat: candidate profile fields
 *
 * Roles are managed by Spatie Laravel-Permission (separate migration).
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('google_id')->nullable()->unique()->comment('Google OAuth ID from Socialite');
            $table->string('avatar')->nullable()->comment('Profile photo URL from Google');
            $table->string('password')->nullable()->comment('Nullable for Google OAuth-only users');
            $table->string('phone', 20)->nullable();
            $table->string('universitas')->nullable()->comment('University / institution name');
            $table->string('jurusan')->nullable()->comment('Study program / major');
            $table->text('alamat')->nullable()->comment('Address');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
