<?php

namespace App\Http\Controllers\WaliMurid;

use App\Http\Controllers\Controller;
use App\Models\SetoranHafalan;
use App\Models\Murojaah;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $wali = Auth::user();
        $santriList = $wali->santriAsWali()->get();

        // Ringkasan per anak
        $ringkasan = [];
        foreach ($santriList as $santri) {
            $ringkasan[] = [
                'santri'          => $santri,
                'total_setoran'   => $santri->setoranHafalan()->count(),
                'total_murojaah'  => $santri->murojaah()->count(),
                'last_setoran'    => $santri->setoranHafalan()->latest('tanggal')->first(),
                'last_murojaah'   => $santri->murojaah()->latest('tanggal')->first(),
            ];
        }

        return view('wali-murid.dashboard', compact('santriList', 'ringkasan'));
    }
}
