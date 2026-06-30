<?php

namespace App\Http\Controllers\WaliMurid;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\PresensiSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $wali = Auth::user();
        $santriList = $wali->santriAsWali()->get();

        $selectedSantriId = $request->input('santri_id', $santriList->first()?->id);

        $riwayat = collect();

        if ($selectedSantriId) {
            $santri = $santriList->firstWhere('id', $selectedSantriId);
            if ($santri) {
                $riwayat = PresensiSantri::with(['presensiKegiatan.kegiatanPondok', 'presensiKegiatan.ustadz'])
                    ->where('santri_id', $santri->id)
                    ->latest('created_at')
                    ->paginate(15);
            }
        }

        return view('wali-murid.riwayat-kegiatan.index', compact(
            'santriList',
            'selectedSantriId',
            'riwayat'
        ));
    }
}
