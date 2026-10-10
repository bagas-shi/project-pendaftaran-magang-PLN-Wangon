<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Berkas (Uploaded Documents)
 *
 * Stores the files uploaded by candidates for each application (pendaftaran).
 * Each document has a type label (e.g. CV, Transkrip, Surat Pengantar) and
 * a path pointing to the stored file.
 *
 * Files are stored in `storage/app/private/berkas/{pendaftaran_id}/` to
 * prevent direct public access — served via a controller with auth checks.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')
                  ->constrained('pendaftaran')
                  ->cascadeOnDelete()
                  ->comment('The application this document belongs to');
            $table->string('jenis_berkas')
                  ->comment('Document type: CV, Transkrip Nilai, Surat Pengantar, KTM, etc.');
            $table->string('nama_asli')
                  ->comment('Original filename as uploaded by the user');
            $table->string('file_path')
                  ->comment('Relative path within storage disk');
            $table->string('mime_type', 100)
                  ->nullable()
                  ->comment('MIME type for validation (e.g. application/pdf)');
            $table->unsignedBigInteger('file_size')
                  ->nullable()
                  ->comment('File size in bytes');
            $table->timestamps();

            // Index for quick lookup by document type
            $table->index('jenis_berkas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
