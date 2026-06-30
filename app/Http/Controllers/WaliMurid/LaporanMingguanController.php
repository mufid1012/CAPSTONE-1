<?php

namespace App\Http\Controllers\WaliMurid;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SetoranHafalan;
use App\Models\Murojaah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanMingguanController extends Controller
{
    public function index(Request $request)
    {
        $wali = Auth::user();
        $santriList = $wali->santriAsWali()->get();

        $selectedSantriId = $request->input('santri_id', $santriList->first()?->id);
        $selectedWeek = $request->input('minggu', Carbon::now()->startOfWeek()->toDateString());

        $weekStart = Carbon::parse($selectedWeek)->startOfWeek(Carbon::MONDAY);
        $weekEnd = $weekStart->copy()->endOfWeek(Carbon::SUNDAY);

        $setoran = [];
        $murojaah = [];

        if ($selectedSantriId) {
            // Validasi santri milik wali
            $santri = $santriList->firstWhere('id', $selectedSantriId);
            if ($santri) {
                $setoran = SetoranHafalan::with('ustadz')
                    ->where('santri_id', $santri->id)
                    ->whereBetween('tanggal', [$weekStart, $weekEnd])
                    ->orderBy('tanggal')
                    ->get();

                $murojaah = Murojaah::with('ustadz')
                    ->where('santri_id', $santri->id)
                    ->whereBetween('tanggal', [$weekStart, $weekEnd])
                    ->orderBy('tanggal')
                    ->get();
            }
        }

        return view('wali-murid.laporan-mingguan.index', compact(
            'santriList',
            'selectedSantriId',
            'selectedWeek',
            'weekStart',
            'weekEnd',
            'setoran',
            'murojaah'
        ));
    }
}
