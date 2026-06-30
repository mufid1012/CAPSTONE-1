<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SetoranHafalan extends Model
{
    protected $table = 'setoran_hafalan';

    public $timestamps = false;

    protected $fillable = [
        'santri_id',
        'ustadz_id',
        'tanggal',
        'juz',
        'surat',
        'ayat',
        'nilai',
        'status_selesai',
        'catatan',
    ];

    protected $casts = [
        'tanggal'        => 'date',
        'nilai'          => 'decimal:2',
        'status_selesai' => 'boolean',
    ];

    // ========================================
    // Relationships
    // ========================================

    /**
     * Santri pemilik setoran.
     */
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    /**
     * Ustadz yang menilai.
     */
    public function ustadz(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ustadz_id');
    }
}
