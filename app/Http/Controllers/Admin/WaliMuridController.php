<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WaliMuridController extends Controller
{
    public function index()
    {
        $waliMuridList = User::role('wali_murid')
                             ->with('santriAsWali')
                             ->withCount('santriAsWali')
                             ->latest()
                             ->paginate(15);

        return view('admin.wali-murid.index', compact('waliMuridList'));
    }

    public function create()
    {
        return view('admin.wali-murid.create');
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

        $user->assignRole('wali_murid');

        return redirect()->route('admin.wali-murid.index')
                         ->with('success', 'Akun wali murid berhasil dibuat.');
    }

    public function show(User $waliMurid)
    {
        $waliMurid->load('santriAsWali');
        return view('admin.wali-murid.show', compact('waliMurid'));
    }

    public function edit(User $waliMurid)
    {
        return view('admin.wali-murid.edit', compact('waliMurid'));
    }

    public function update(Request $request, User $waliMurid)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $waliMurid->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $waliMurid->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $waliMurid->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('admin.wali-murid.index')
                         ->with('success', 'Akun wali murid berhasil diperbarui.');
    }

    public function destroy(User $waliMurid)
    {
        $waliMurid->delete();

        return redirect()->route('admin.wali-murid.index')
                         ->with('success', 'Akun wali murid berhasil dihapus.');
    }
}
