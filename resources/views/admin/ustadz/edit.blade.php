@extends('layouts.app')
@section('title', 'Edit Ustadz')
@section('page-title', 'Edit Akun Ustadz')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('admin.ustadz.update', $ustadz) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $ustadz->name) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $ustadz->email) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-xs text-gray-400">(kosongkan jika tidak diubah)</span></label>
                        <input type="password" name="password" id="password" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Perbarui</button>
                    <a href="{{ route('admin.ustadz.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
