<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\KegiatanPondok;
use App\Models\User;
use App\Models\PresensiKegiatan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_santri'    => Santri::count(),
            'total_ustadz'    => User::role('ustadz')->count(),
            'total_kegiatan'  => KegiatanPondok::count(),
            'total_wali'      => User::role('wali_murid')->count(),
            'presensi_hari_ini' => PresensiKegiatan::whereDate('tanggal', today())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
