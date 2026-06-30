<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresensiSantri extends Model
{
    protected $table = 'presensi_santri';

    public $timestamps = false;

    protected $fillable = [
        'presensi_kegiatan_id',
        'santri_id',
        'status',
    ];

    // ========================================
    // Relationships
    // ========================================

    /**
     * Sesi presensi kegiatan terkait.
     */
    public function presensiKegiatan(): BelongsTo
    {
        return $this->belongsTo(PresensiKegiatan::class, 'presensi_kegiatan_id');
    }

    /**
     * Santri yang dicatat kehadirannya.
     */
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
}
