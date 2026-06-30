<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PresensiKegiatan extends Model
{
    protected $table = 'presensi_kegiatan';

    public $timestamps = false;

    protected $fillable = [
        'kegiatan_pondok_id',
        'ustadz_id',
        'tanggal',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'materi',
        'latitude',
        'longitude',
        'status',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'latitude'  => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    // ========================================
    // Relationships
    // ========================================

    /**
     * Kegiatan pondok terkait.
     */
    public function kegiatanPondok(): BelongsTo
    {
        return $this->belongsTo(KegiatanPondok::class, 'kegiatan_pondok_id');
    }

    /**
     * Ustadz yang melakukan presensi.
     */
    public function ustadz(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ustadz_id');
    }

    /**
     * Daftar presensi santri pada sesi ini.
     */
    public function presensiSantri(): HasMany
    {
        return $this->hasMany(PresensiSantri::class, 'presensi_kegiatan_id');
    }

    // ========================================
    // Helpers
    // ========================================

    /**
     * Cek apakah presensi ini sudah tervalidasi lokasinya.
     */
    public function isValid(): bool
    {
        return $this->status === 'valid';
    }
}
