<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\PresensiKegiatan;
use App\Models\PresensiSantri;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiSantriController extends Controller
{
    /**
     * Form presensi santri (checklist).
     * Hanya bisa diakses jika presensi kegiatan ustadz sudah valid.
     */
    public function create(PresensiKegiatan $presensiKegiatan)
    {
        $this->authorizePresensi($presensiKegiatan);

        // Ambil semua santri untuk dicatat kehadirannya
        $santriList = Santri::orderBy('nama')->get();

        // Ambil presensi santri yang sudah ada (jika sudah pernah diisi)
        $existingPresensi = $presensiKegiatan->presensiSantri()
                                ->pluck('status', 'santri_id')
                                ->toArray();

        return view('ustadz.presensi-santri.create', compact(
            'presensiKegiatan',
            'santriList',
            'existingPresensi'
        ));
    }

    /**
     * Simpan presensi santri secara bulk.
     */
    public function store(Request $request, PresensiKegiatan $presensiKegiatan)
    {
        $this->authorizePresensi($presensiKegiatan);

        $validated = $request->validate([
            'presensi'          => 'required|array',
            'presensi.*.santri_id' => 'required|exists:santri,id',
            'presensi.*.status'    => 'required|in:hadir,izin,sakit,alpha',
        ]);

        foreach ($validated['presensi'] as $item) {
            PresensiSantri::updateOrCreate(
                [
                    'presensi_kegiatan_id' => $presensiKegiatan->id,
                    'santri_id'            => $item['santri_id'],
                ],
                [
                    'status' => $item['status'],
                ]
            );
        }

        return redirect()->route('ustadz.presensi-kegiatan.show', $presensiKegiatan)
                         ->with('success', 'Presensi santri berhasil disimpan.');
    }

    /**
     * Otorisasi: presensi harus milik ustadz yang login dan statusnya valid.
     */
    private function authorizePresensi(PresensiKegiatan $presensiKegiatan): void
    {
        if ($presensiKegiatan->ustadz_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke presensi ini.');
        }

        if (!$presensiKegiatan->isValid()) {
            abort(403, 'Presensi kegiatan belum tervalidasi. Silakan lakukan presensi diri terlebih dahulu.');
        }
    }
}
