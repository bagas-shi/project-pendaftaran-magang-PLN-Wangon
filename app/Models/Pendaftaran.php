<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'tanggal_daftar',
        'catatan_admin',
    ];

    public const STATUS_DIAJUKAN     = 'diajukan';
    public const STATUS_DIVERIFIKASI = 'diverifikasi';
    public const STATUS_DITERIMA     = 'diterima';
    public const STATUS_DITOLAK      = 'ditolak';

    public const STATUSES = [
        self::STATUS_DIAJUKAN,
        self::STATUS_DIVERIFIKASI,
        self::STATUS_DITERIMA,
        self::STATUS_DITOLAK,
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
            'tanggal_daftar'  => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function berkas(): HasMany
    {
        return $this->hasMany(Berkas::class);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DIAJUKAN     => 'Diajukan',
            self::STATUS_DIVERIFIKASI => 'Diverifikasi',
            self::STATUS_DITERIMA     => 'Diterima',
            self::STATUS_DITOLAK      => 'Ditolak',
            default                   => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DIAJUKAN     => 'bg-yellow-100 text-yellow-800',
            self::STATUS_DIVERIFIKASI => 'bg-blue-100 text-blue-800',
            self::STATUS_DITERIMA     => 'bg-green-100 text-green-800',
            self::STATUS_DITOLAK      => 'bg-red-100 text-red-800',
            default                   => 'bg-gray-100 text-gray-800',
        };
    }

    public function isEditable(): bool
    {
        return $this->status === self::STATUS_DIAJUKAN;
    }
}
