<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::with('waliMurid')->latest();

        if ($request->filled('tingkatan')) {
            $query->where('tingkatan', $request->tingkatan);
        }
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $santriList = $query->paginate(15)->appends($request->query());

        // Get distinct kelas values for filter
        $kelasList = Santri::select('kelas')->whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        return view('admin.santri.index', compact('santriList', 'kelasList'));
    }

    public function create()
    {
        $waliMuridList = User::role('wali_murid')->orderBy('name')->get();
        return view('admin.santri.create', compact('waliMuridList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'nis'            => 'required|string|max:50|unique:santri,nis',
            'kelas'          => 'nullable|string|max:50',
            'tingkatan'      => 'required|in:tsanawiyah,aliyah,takhassus',
            'wali_murid_id'  => 'nullable|exists:users,id',
            'tanggal_lahir'  => 'nullable|date',
        ]);

        Santri::create($validated);

        return redirect()->route('admin.santri.index')
                         ->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function edit(Santri $santri)
    {
        $waliMuridList = User::role('wali_murid')->orderBy('name')->get();
        return view('admin.santri.edit', compact('santri', 'waliMuridList'));
    }

    public function update(Request $request, Santri $santri)
    {
        $validated = $request->validate([
            'nama'           => 'required|string|max:255',
            'nis'            => 'required|string|max:50|unique:santri,nis,' . $santri->id,
            'kelas'          => 'nullable|string|max:50',
            'tingkatan'      => 'required|in:tsanawiyah,aliyah,takhassus',
            'wali_murid_id'  => 'nullable|exists:users,id',
            'tanggal_lahir'  => 'nullable|date',
        ]);

        $santri->update($validated);

        return redirect()->route('admin.santri.index')
                         ->with('success', 'Data santri berhasil diperbarui.');
    }

    public function destroy(Santri $santri)
    {
        $santri->delete();

        return redirect()->route('admin.santri.index')
                         ->with('success', 'Data santri berhasil dihapus.');
    }
}
