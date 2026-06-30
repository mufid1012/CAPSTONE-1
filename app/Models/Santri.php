<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Santri extends Model
{
    protected $table = 'santri';

    const TINGKATAN_LABELS = [
        'tsanawiyah' => 'Tsanawiyah (MTs/SMP)',
        'aliyah'     => 'Aliyah (MA/SMA)',
        'takhassus'  => 'Takhassus',
    ];

    protected $fillable = [
        'nama',
        'nis',
        'kelas',
        'tingkatan',
        'wali_murid_id',
        'tanggal_lahir',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function getTingkatanLabelAttribute(): string
    {
        return self::TINGKATAN_LABELS[$this->tingkatan] ?? $this->tingkatan;
    }

    // ========================================
    // Relationships
    // ========================================

    /**
     * Wali murid dari santri ini.
     */
    public function waliMurid(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_murid_id');
    }

    /**
     * Ustadz pembina santri ini.
     */
    public function ustadzPembina(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ustadz_santri', 'santri_id', 'user_id')
                    ->withPivot('created_at');
    }

    /**
     * Presensi santri di berbagai kegiatan.
     */
    public function presensiSantri(): HasMany
    {
        return $this->hasMany(PresensiSantri::class, 'santri_id');
    }

    /**
     * Setoran hafalan santri.
     */
    public function setoranHafalan(): HasMany
    {
        return $this->hasMany(SetoranHafalan::class, 'santri_id');
    }

    /**
     * Murojaah santri.
     */
    public function murojaah(): HasMany
    {
        return $this->hasMany(Murojaah::class, 'santri_id');
    }
}
