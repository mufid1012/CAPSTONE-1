<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\PresensiKegiatan;
use App\Services\GeolocationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiKegiatanController extends Controller
{
    public function __construct(
        protected GeolocationService $geoService
    ) {}

    /**
     * Daftar riwayat presensi ustadz.
     */
    public function index()
    {
        $presensiList = PresensiKegiatan::with('kegiatanPondok')
                            ->where('ustadz_id', Auth::id())
                            ->latest('tanggal')
                            ->paginate(15);

        return view('ustadz.presensi-kegiatan.index', compact('presensiList'));
    }

    /**
     * Form presensi kegiatan + geolocation.
     */
    public function create()
    {
        $kegiatanDiampu = Auth::user()->kegiatanPondok()->orderBy('nama_kegiatan')->get();

        return view('ustadz.presensi-kegiatan.create', compact('kegiatanDiampu'));
    }

    /**
     * Simpan presensi kegiatan dengan validasi geolocation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kegiatan_pondok_id' => 'required|exists:kegiatan_pondok,id',
            'materi'             => 'nullable|string',
            'jam_mulai'          => 'required|date_format:H:i',
            'jam_selesai'        => 'nullable|date_format:H:i|after:jam_mulai',
            'latitude'           => 'required|numeric|between:-90,90',
            'longitude'          => 'required|numeric|between:-180,180',
        ]);

        // Validasi: ustadz hanya bisa presensi pada kegiatan yang diampu
        $ustadz = Auth::user();
        if (!$ustadz->kegiatanPondok()->where('kegiatan_pondok.id', $validated['kegiatan_pondok_id'])->exists()) {
            return back()->withErrors(['kegiatan_pondok_id' => 'Anda tidak mengampu kegiatan ini.'])->withInput();
        }

        // Validasi geolocation
        $isWithinRadius = $this->geoService->isWithinRadius(
            (float) $validated['latitude'],
            (float) $validated['longitude']
        );

        if (!$isWithinRadius) {
            $distance = $this->geoService->calculateDistance(
                (float) $validated['latitude'],
                (float) $validated['longitude'],
                config('pptq.pesantren_latitude'),
                config('pptq.pesantren_longitude')
            );

            return back()->withErrors([
                'geolocation' => 'Presensi gagal! Lokasi Anda berada di luar radius pesantren (' . round($distance) . ' meter dari lokasi pesantren). Radius maksimal: ' . config('pptq.radius_meter') . ' meter.',
            ])->withInput();
        }

        $tanggal = Carbon::today();

        $presensi = PresensiKegiatan::create([
            'kegiatan_pondok_id' => $validated['kegiatan_pondok_id'],
            'ustadz_id'          => $ustadz->id,
            'tanggal'            => $tanggal->toDateString(),
            'hari'               => $this->getHariIndonesia($tanggal),
            'jam_mulai'          => $validated['jam_mulai'],
            'jam_selesai'        => $validated['jam_selesai'] ?? null,
            'materi'             => $validated['materi'] ?? null,
            'latitude'           => $validated['latitude'],
            'longitude'          => $validated['longitude'],
            'status'             => 'valid',
        ]);

        return redirect()->route('ustadz.presensi-kegiatan.show', $presensi)
                         ->with('success', 'Presensi berhasil! Silakan lanjutkan presensi santri.');
    }

    /**
     * Detail presensi kegiatan + link ke presensi santri.
     */
    public function show(PresensiKegiatan $presensiKegiatan)
    {
        // Pastikan presensi milik ustadz yang login
        if ($presensiKegiatan->ustadz_id !== Auth::id()) {
            abort(403);
        }

        $presensiKegiatan->load(['kegiatanPondok', 'presensiSantri.santri']);

        return view('ustadz.presensi-kegiatan.show', compact('presensiKegiatan'));
    }

    /**
     * Convert Carbon day name to Indonesian.
     */
    private function getHariIndonesia(Carbon $date): string
    {
        $days = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        return $days[$date->englishDayOfWeek] ?? $date->englishDayOfWeek;
    }
}
