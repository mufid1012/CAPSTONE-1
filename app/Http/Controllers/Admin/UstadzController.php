<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UstadzController extends Controller
{
    public function index()
    {
        $ustadzList = User::role('ustadz')
                          ->withCount(['kegiatanPondok', 'santriBinaan'])
                          ->latest()
                          ->paginate(15);

        return view('admin.ustadz.index', compact('ustadzList'));
    }

    public function create()
    {
        return view('admin.ustadz.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole('ustadz');

        return redirect()->route('admin.ustadz.index')
                         ->with('success', 'Akun ustadz berhasil dibuat.');
    }

    public function show(User $ustadz)
    {
        $ustadz->load(['kegiatanPondok', 'santriBinaan']);
        return view('admin.ustadz.show', compact('ustadz'));
    }

    public function edit(User $ustadz)
    {
        return view('admin.ustadz.edit', compact('ustadz'));
    }

    public function update(Request $request, User $ustadz)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $ustadz->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $ustadz->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $ustadz->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('admin.ustadz.index')
                         ->with('success', 'Akun ustadz berhasil diperbarui.');
    }

    public function destroy(User $ustadz)
    {
        $ustadz->delete();

        return redirect()->route('admin.ustadz.index')
                         ->with('success', 'Akun ustadz berhasil dihapus.');
    }
}
