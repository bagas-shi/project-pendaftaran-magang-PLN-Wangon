<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Pendaftaran (Applications / Registrations)
 *
 * Each row represents a single internship application by a user.
 * Candidates define their own start and end dates.
 * Status flow:
 *   diajukan → diverifikasi → diterima / ditolak
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->comment('The candidate who submitted the application');
            $table->date('tanggal_mulai')->comment('Candidate chosen start date');
            $table->date('tanggal_selesai')->comment('Candidate chosen end date');
            $table->enum('status', ['diajukan', 'diverifikasi', 'diterima', 'ditolak'])
                  ->default('diajukan')
                  ->comment('Application status');
            $table->date('tanggal_daftar')->comment('Date the application was submitted');
            $table->text('catatan_admin')->nullable()->comment('Internal admin notes / rejection reason');
            $table->timestamps();

            // Index for filtering by status
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
