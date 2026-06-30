<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;

class UstadzSantriController extends Controller
{
    public function index(Request $request)
    {
        $selectedUstadzId = $request->input('ustadz_id');
        $filterTingkatan = $request->input('tingkatan');
        $filterKelas = $request->input('kelas');

        $allUstadz = User::role('ustadz')->orderBy('name')->get();

        $ustadzList = collect();

        $santriQuery = Santri::orderBy('nama');
        if ($filterTingkatan) {
            $santriQuery->where('tingkatan', $filterTingkatan);
        }
        if ($filterKelas) {
            $santriQuery->where('kelas', $filterKelas);
        }
        $santriList = $santriQuery->get();

        if ($selectedUstadzId) {
            $ustadzList = User::role('ustadz')
                ->where('id', $selectedUstadzId)
                ->with('santriBinaan')
                ->get();
        } else {
            $ustadzList = User::role('ustadz')
                ->with('santriBinaan')
                ->orderBy('name')
                ->get();
        }

        return view('admin.santri-binaan.index', compact('ustadzList', 'santriList', 'allUstadz', 'selectedUstadzId', 'filterTingkatan', 'filterKelas'));
    }

    public function update(Request $request, User $ustadz)
    {
        $validated = $request->validate([
            'santri_ids'   => 'nullable|array',
            'santri_ids.*' => 'exists:santri,id',
        ]);

        $ustadz->santriBinaan()->sync($validated['santri_ids'] ?? []);

        return redirect()->route('admin.santri-binaan.index', ['ustadz_id' => $ustadz->id])
                         ->with('success', "Santri binaan untuk {$ustadz->name} berhasil diperbarui.");
    }
}
