<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ========================================
    // Helper methods for role checking
    // ========================================

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isUstadz(): bool
    {
        return $this->hasRole('ustadz');
    }

    public function isWaliMurid(): bool
    {
        return $this->hasRole('wali_murid');
    }

    // ========================================
    // Relationships
    // ========================================

    /**
     * Santri yang merupakan anak dari wali murid ini.
     */
    public function santriAsWali(): HasMany
    {
        return $this->hasMany(Santri::class, 'wali_murid_id');
    }

    /**
     * Kegiatan pondok yang diampu oleh ustadz ini.
     */
    public function kegiatanPondok(): BelongsToMany
    {
        return $this->belongsToMany(KegiatanPondok::class, 'ustadz_kegiatan', 'user_id', 'kegiatan_pondok_id')
                    ->withPivot('created_at');
    }

    /**
     * Santri binaan dari ustadz ini.
     */
    public function santriBinaan(): BelongsToMany
    {
        return $this->belongsToMany(Santri::class, 'ustadz_santri', 'user_id', 'santri_id')
                    ->withPivot('created_at');
    }

    /**
     * Presensi kegiatan yang dilakukan oleh ustadz ini.
     */
    public function presensiKegiatan(): HasMany
    {
        return $this->hasMany(PresensiKegiatan::class, 'ustadz_id');
    }

    /**
     * Setoran hafalan yang dinilai oleh ustadz ini.
     */
    public function setoranHafalan(): HasMany
    {
        return $this->hasMany(SetoranHafalan::class, 'ustadz_id');
    }

    /**
     * Murojaah yang dinilai oleh ustadz ini.
     */
    public function murojaah(): HasMany
    {
        return $this->hasMany(Murojaah::class, 'ustadz_id');
    }
}
