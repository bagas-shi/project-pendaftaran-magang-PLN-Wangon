<?php

namespace App\Models;

use Database\Factories\UserFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Model: User
 *
 * Represents all system users — candidates (peserta), admins, and super admins.
 * Role management is handled via Spatie HasRoles trait.
 * Google OAuth users are identified by the `google_id` column.
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'phone',
        'universitas',
        'jurusan',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ──────────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────────

    /**
     * A user (candidate) can have many internship applications.
     */
    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    // ──────────────────────────────────────────────
    // Accessors & Helpers
    // ──────────────────────────────────────────────

    /**
     * Check if the user registered via Google OAuth.
     */
    public function isGoogleUser(): bool
    {
        return ! is_null($this->google_id);
    }

    /**
     * Get the user's display avatar (Google avatar or default).
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0D8ABC&color=fff';
    }
}
