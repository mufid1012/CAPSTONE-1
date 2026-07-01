<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanPondok;
use App\Models\User;
use Illuminate\Http\Request;

class UstadzKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $selectedUstadzId = $request->input('ustadz_id');

        $allUstadz = User::role('ustadz')->orderBy('name')->get();

        $ustadzList = collect();
        $kegiatanList = KegiatanPondok::orderBy('nama_kegiatan')->get();

        if ($request->filled('tingkatan') && $request->tingkatan !== 'semua') {
            $kegiatanList = $kegiatanList->filter(fn($k) => $k->tingkatan === $request->tingkatan || $k->tingkatan === 'semua');
        }
        if ($request->filled('kelas')) {
            $kegiatanList = $kegiatanList->filter(fn($k) => $k->kelas === $request->kelas || empty($k->kelas));
        }

        if ($selectedUstadzId) {
            $ustadzList = User::role('ustadz')
                ->where('id', $selectedUstadzId)
                ->with('kegiatanPondok')
                ->get();
        } else {
            $ustadzList = User::role('ustadz')
                ->with('kegiatanPondok')
                ->orderBy('name')
                ->get();
        }

        return view('admin.penugasan-kegiatan.index', compact('ustadzList', 'kegiatanList', 'allUstadz', 'selectedUstadzId'));
    }

    public function update(Request $request, User $ustadz)
    {
        $validated = $request->validate([
            'kegiatan_ids'   => 'nullable|array',
            'kegiatan_ids.*' => 'exists:kegiatan_pondok,id',
        ]);

        $ustadz->kegiatanPondok()->sync($validated['kegiatan_ids'] ?? []);

        return redirect()->route('admin.penugasan-kegiatan.index', ['ustadz_id' => $ustadz->id])
                         ->with('success', "Penugasan kegiatan untuk {$ustadz->name} berhasil diperbarui.");
    }
}
