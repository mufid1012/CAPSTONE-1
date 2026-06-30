<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KegiatanPondok;
use Illuminate\Http\Request;

class KegiatanPondokController extends Controller
{
    public function index(Request $request)
    {
        $query = KegiatanPondok::withCount('ustadz')->latest();

        if ($request->filled('tingkatan')) {
            $query->where('tingkatan', $request->tingkatan);
        }

        $kegiatan = $query->paginate(15)->appends($request->query());
        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'tingkatan'     => 'required|in:semua,tsanawiyah,aliyah,takhassus',
        ]);

        KegiatanPondok::create($validated);

        return redirect()->route('admin.kegiatan.index')
                         ->with('success', 'Kegiatan pondok berhasil ditambahkan.');
    }

    public function show(KegiatanPondok $kegiatan)
    {
        $kegiatan->load('ustadz');
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function edit(KegiatanPondok $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, KegiatanPondok $kegiatan)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'tingkatan'     => 'required|in:semua,tsanawiyah,aliyah,takhassus',
        ]);

        $kegiatan->update($validated);

        return redirect()->route('admin.kegiatan.index')
                         ->with('success', 'Kegiatan pondok berhasil diperbarui.');
    }

    public function destroy(KegiatanPondok $kegiatan)
    {
        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
                         ->with('success', 'Kegiatan pondok berhasil dihapus.');
    }
}
