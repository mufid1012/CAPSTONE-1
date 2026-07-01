<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\SetoranHafalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetoranHafalanController extends Controller
{
    public function index(Request $request)
    {
        $santriBinaanQuery = Auth::user()->santriBinaan()->orderBy('nama');
        if ($request->filled('tingkatan')) {
            $santriBinaanQuery->where('tingkatan', $request->tingkatan);
        }
        $santriBinaan = $santriBinaanQuery->get();
        $selectedSantriId = $request->input('santri_id');

        $setoranList = collect(); // empty by default

        if ($selectedSantriId) {
            // Validasi santri milik ustadz
            if ($santriBinaan->contains('id', (int) $selectedSantriId)) {
                $setoranList = SetoranHafalan::with('santri')
                    ->where('ustadz_id', Auth::id())
                    ->where('santri_id', $selectedSantriId)
                    ->latest('tanggal')
                    ->paginate(15)
                    ->appends($request->query());
            }
        }

        return view('ustadz.setoran-hafalan.index', compact('santriBinaan', 'selectedSantriId', 'setoranList'));
    }

    public function create()
    {
        $santriBinaan = Auth::user()->santriBinaan()->orderBy('nama')->get();

        return view('ustadz.setoran-hafalan.create', compact('santriBinaan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id'      => 'required|exists:santri,id',
            'tanggal'        => 'required|date',
            'juz'            => 'required|integer|min:1|max:30',
            'surat'          => 'required|string|max:100',
            'ayat'           => 'required|string|max:50',
            'nilai'          => 'nullable|numeric|min:0|max:100',
            'catatan'        => 'nullable|string',
        ]);

        // Validasi: santri harus merupakan binaan ustadz
        $ustadz = Auth::user();
        if (!$ustadz->santriBinaan()->where('santri.id', $validated['santri_id'])->exists()) {
            return back()->with('error', 'Santri tersebut bukan binaan Anda.');
        }

        $validated['ustadz_id'] = $ustadz->id;
        $validated['status_selesai'] = $request->has('status_selesai') ? (bool) $request->status_selesai : false;

        SetoranHafalan::create($validated);

        return redirect()->route('ustadz.setoran-hafalan.index', ['santri_id' => $validated['santri_id']])
                         ->with('success', 'Setoran hafalan berhasil disimpan.');
    }

    public function show(SetoranHafalan $setoranHafalan)
    {
        if ($setoranHafalan->ustadz_id !== Auth::id()) {
            abort(403);
        }

        $setoranHafalan->load('santri');

        return view('ustadz.setoran-hafalan.show', compact('setoranHafalan'));
    }
}
