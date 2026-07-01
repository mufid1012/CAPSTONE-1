<?php

namespace App\Http\Controllers\Ustadz;

use App\Http\Controllers\Controller;
use App\Models\Murojaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MurojaahController extends Controller
{
    public function index(Request $request)
    {
        $santriBinaanQuery = Auth::user()->santriBinaan()->orderBy('nama');
        if ($request->filled('tingkatan')) {
            $santriBinaanQuery->where('tingkatan', $request->tingkatan);
        }
        $santriBinaan = $santriBinaanQuery->get();
        $selectedSantriId = $request->input('santri_id');

        $murojaahList = collect(); // empty by default

        if ($selectedSantriId) {
            if ($santriBinaan->contains('id', (int) $selectedSantriId)) {
                $murojaahList = Murojaah::with('santri')
                    ->where('ustadz_id', Auth::id())
                    ->where('santri_id', $selectedSantriId)
                    ->latest('tanggal')
                    ->paginate(15)
                    ->appends($request->query());
            }
        }

        return view('ustadz.murojaah.index', compact('santriBinaan', 'selectedSantriId', 'murojaahList'));
    }

    public function create()
    {
        $santriBinaan = Auth::user()->santriBinaan()->orderBy('nama')->get();

        return view('ustadz.murojaah.create', compact('santriBinaan'));
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
        ]);

        $ustadz = Auth::user();
        if (!$ustadz->santriBinaan()->where('santri.id', $validated['santri_id'])->exists()) {
            return back()->withErrors(['santri_id' => 'Santri ini bukan binaan Anda.'])->withInput();
        }

        $validated['ustadz_id'] = $ustadz->id;
        $validated['status_selesai'] = $request->has('status_selesai') ? (bool) $request->status_selesai : false;

        Murojaah::create($validated);

        return redirect()->route('ustadz.murojaah.index', ['santri_id' => $validated['santri_id']])
                         ->with('success', 'Murojaah berhasil disimpan.');
    }

    public function show(Murojaah $murojaah)
    {
        if ($murojaah->ustadz_id !== Auth::id()) {
            abort(403);
        }

        $murojaah->load('santri');

        return view('ustadz.murojaah.show', compact('murojaah'));
    }
}
