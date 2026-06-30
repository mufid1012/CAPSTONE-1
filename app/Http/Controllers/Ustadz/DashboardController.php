<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\PresensiKegiatan;
use App\Models\SetoranHafalan;
use App\Models\Murojaah;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $ustadz = Auth::user();

        $stats = [
            'total_kegiatan_diampu' => $ustadz->kegiatanPondok()->count(),
            'total_santri_binaan'   => $ustadz->santriBinaan()->count(),
            'presensi_bulan_ini'    => PresensiKegiatan::where('ustadz_id', $ustadz->id)
                                        ->whereMonth('tanggal', now()->month)
                                        ->whereYear('tanggal', now()->year)
                                        ->count(),
            'setoran_bulan_ini'     => SetoranHafalan::where('ustadz_id', $ustadz->id)
                                        ->whereMonth('tanggal', now()->month)
                                        ->whereYear('tanggal', now()->year)
                                        ->count(),
        ];

        $recentPresensi = PresensiKegiatan::with('kegiatanPondok')
                            ->where('ustadz_id', $ustadz->id)
                            ->latest('tanggal')
                            ->take(5)
                            ->get();

        return view('ustadz.dashboard', compact('stats', 'recentPresensi'));
    }
}
