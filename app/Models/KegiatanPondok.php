<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KegiatanPondok extends Model
{
    protected $table = 'kegiatan_pondok';

    const TINGKATAN_OPTIONS = [
        'semua'      => 'Semua Tingkatan',
        'tsanawiyah' => 'Tsanawiyah (MTs/SMP)',
        'aliyah'     => 'Aliyah (MA/SMA)',
        'takhassus'  => 'Takhassus',
    ];

    const KELAS_OPTIONS = [
        'tsanawiyah' => ['7', '8', '9'],
        'aliyah'     => ['10', '11', '12'],
        'takhassus'  => ['Takhassus'],
    ];

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'tingkatan',
        'kelas',
    ];

    public function getTingkatanLabelAttribute(): string
    {
        return self::TINGKATAN_OPTIONS[$this->tingkatan] ?? $this->tingkatan;
    }

    // ========================================
    // Relationships
    // ========================================

    /**
     * Ustadz yang mengampu kegiatan ini.
     */
    public function ustadz(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ustadz_kegiatan', 'kegiatan_pondok_id', 'user_id')
                    ->withPivot('created_at');
    }

    /**
     * Presensi kegiatan terkait.
     */
    public function presensiKegiatan(): HasMany
    {
        return $this->hasMany(PresensiKegiatan::class, 'kegiatan_pondok_id');
    }
}
