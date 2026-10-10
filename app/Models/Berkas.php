<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * Model: Berkas (Uploaded Document)
 *
 * Represents a single file uploaded by a candidate as part of their
 * internship application. Documents are stored privately and served
 * through authenticated controller routes.
 *
 * Supported document types: CV, Transkrip Nilai, Surat Pengantar, KTM, etc.
 */
class Berkas extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftaran_id',
        'jenis_berkas',
        'nama_asli',
        'file_path',
        'mime_type',
        'file_size',
    ];

    /**
     * The table associated with the model.
     */
    protected $table = 'berkas';

    /**
     * Supported document type constants.
     */
    public const JENIS_CV              = 'CV';
    public const JENIS_TRANSKRIP       = 'Transkrip Nilai';
    public const JENIS_SURAT_PENGANTAR = 'Surat Pengantar';
    public const JENIS_KTM             = 'KTM';
    public const JENIS_PROPOSAL        = 'Proposal';

    /**
     * All allowed document types.
     */
    public const JENIS_LIST = [
        self::JENIS_CV,
        self::JENIS_TRANSKRIP,
        self::JENIS_SURAT_PENGANTAR,
        self::JENIS_KTM,
        self::JENIS_PROPOSAL,
    ];

    /**
     * Required document types that must be uploaded.
     */
    public const JENIS_REQUIRED = [
        self::JENIS_CV,
        self::JENIS_TRANSKRIP,
        self::JENIS_SURAT_PENGANTAR,
    ];

    // ──────────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────────

    /**
     * The application this document belongs to.
     */
    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    // ──────────────────────────────────────────────
    // Accessors & Helpers
    // ──────────────────────────────────────────────

    /**
     * Get the full storage URL for downloading the file.
     * Files are stored privately; use this in an auth-gated controller.
     */
    public function getFileUrlAttribute(): ?string
    {
        if (Storage::disk('private')->exists($this->file_path)) {
            return route('berkas.download', $this->id);
        }

        return null;
    }

    /**
     * Get human-readable file size.
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size ?? 0;

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }

    /**
     * Delete the physical file when the model is deleted.
     */
    protected static function booted(): void
    {
        static::deleting(function (Berkas $berkas) {
            if (Storage::disk('private')->exists($berkas->file_path)) {
                Storage::disk('private')->delete($berkas->file_path);
            }
        });
    }
}
