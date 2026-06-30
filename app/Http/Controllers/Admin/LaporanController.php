<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanPondok;
use App\Models\Murojaah;
use App\Models\PresensiKegiatan;
use App\Models\PresensiSantri;
use App\Models\Santri;
use App\Models\SetoranHafalan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Laporan Presensi Ustadz
     */
    public function presensiUstadz(Request $request)
    {
        $query = PresensiKegiatan::with(['ustadz', 'kegiatanPondok'])->latest('tanggal');

        if ($request->filled('bulan')) {
            $date = Carbon::createFromFormat('Y-m', $request->bulan);
            $query->whereYear('tanggal', $date->year)->whereMonth('tanggal', $date->month);
        }

        if ($request->filled('ustadz_id')) {
            $query->where('ustadz_id', $request->ustadz_id);
        }

        if ($request->filled('kegiatan_pondok_id')) {
            $query->where('kegiatan_pondok_id', $request->kegiatan_pondok_id);
        }

        $presensiList = $query->paginate(20)->appends($request->query());
        $allUstadz = User::role('ustadz')->orderBy('name')->get();
        $allKegiatan = KegiatanPondok::orderBy('nama_kegiatan')->get();

        return view('admin.laporan.presensi-ustadz', compact('presensiList', 'allUstadz', 'allKegiatan'));
    }

    /**
     * Laporan Presensi Santri
     */
    public function presensiSantri(Request $request)
    {
        $query = PresensiSantri::with(['presensiKegiatan.kegiatanPondok', 'santri']);

        // Order by latest presensi date
        $query->whereHas('presensiKegiatan', function ($q) use ($request) {
            if ($request->filled('bulan')) {
                $date = Carbon::createFromFormat('Y-m', $request->bulan);
                $q->whereYear('tanggal', $date->year)->whereMonth('tanggal', $date->month);
            }
            if ($request->filled('kegiatan_pondok_id')) {
                $q->where('kegiatan_pondok_id', $request->kegiatan_pondok_id);
            }
        });

        // Add proper ordering by date
        $query->join('presensi_kegiatan', 'presensi_santri.presensi_kegiatan_id', '=', 'presensi_kegiatan.id')
              ->select('presensi_santri.*')
              ->orderBy('presensi_kegiatan.tanggal', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('santri_id')) {
            $query->where('santri_id', $request->santri_id);
        }

        if ($request->filled('tingkatan') && $request->tingkatan !== 'semua') {
            $query->whereHas('santri', function ($q) use ($request) {
                $q->where('tingkatan', $request->tingkatan);
            });
        }

        $presensiList = $query->paginate(20)->appends($request->query());
        $allKegiatan = KegiatanPondok::orderBy('nama_kegiatan')->get();
        
        $santriQuery = Santri::orderBy('nama');
        if ($request->filled('tingkatan') && $request->tingkatan !== 'semua') {
            $santriQuery->where('tingkatan', $request->tingkatan);
        }
        $allSantri = $santriQuery->get();

        return view('admin.laporan.presensi-santri', compact('presensiList', 'allKegiatan', 'allSantri'));
    }

    /**
     * Laporan Setoran Hafalan
     */
    public function hafalan(Request $request)
    {
        $query = SetoranHafalan::with(['santri', 'ustadz'])->latest('tanggal');

        if ($request->filled('bulan')) {
            $date = Carbon::createFromFormat('Y-m', $request->bulan);
            $query->whereYear('tanggal', $date->year)->whereMonth('tanggal', $date->month);
        }

        if ($request->filled('santri_id')) {
            $query->where('santri_id', $request->santri_id);
        }

        if ($request->filled('ustadz_id')) {
            $query->where('ustadz_id', $request->ustadz_id);
        }

        if ($request->filled('tingkatan') && $request->tingkatan !== 'semua') {
            $query->whereHas('santri', function ($q) use ($request) {
                $q->where('tingkatan', $request->tingkatan);
            });
        }

        $hafalanList = $query->paginate(20)->appends($request->query());
        $allUstadz = User::role('ustadz')->orderBy('name')->get();
        
        $santriQuery = Santri::orderBy('nama');
        if ($request->filled('tingkatan') && $request->tingkatan !== 'semua') {
            $santriQuery->where('tingkatan', $request->tingkatan);
        }
        $allSantri = $santriQuery->get();

        return view('admin.laporan.hafalan', compact('hafalanList', 'allUstadz', 'allSantri'));
    }

    /**
     * Laporan Murojaah
     */
    public function murojaah(Request $request)
    {
        $query = Murojaah::with(['santri', 'ustadz'])->latest('tanggal');

        if ($request->filled('bulan')) {
            $date = Carbon::createFromFormat('Y-m', $request->bulan);
            $query->whereYear('tanggal', $date->year)->whereMonth('tanggal', $date->month);
        }

        if ($request->filled('santri_id')) {
            $query->where('santri_id', $request->santri_id);
        }

        if ($request->filled('ustadz_id')) {
            $query->where('ustadz_id', $request->ustadz_id);
        }

        if ($request->filled('tingkatan') && $request->tingkatan !== 'semua') {
            $query->whereHas('santri', function ($q) use ($request) {
                $q->where('tingkatan', $request->tingkatan);
            });
        }

        $murojaahList = $query->paginate(20)->appends($request->query());
        $allUstadz = User::role('ustadz')->orderBy('name')->get();
        
        $santriQuery = Santri::orderBy('nama');
        if ($request->filled('tingkatan') && $request->tingkatan !== 'semua') {
            $santriQuery->where('tingkatan', $request->tingkatan);
        }
        $allSantri = $santriQuery->get();

        return view('admin.laporan.murojaah', compact('murojaahList', 'allUstadz', 'allSantri'));
    }
}
