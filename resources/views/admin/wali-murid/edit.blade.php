@extends('layouts.app')
@section('title', 'Edit Wali Murid')
@section('page-title', 'Edit Akun Wali Murid')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('admin.wali-murid.update', $waliMurid) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $waliMurid->name) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $waliMurid->email) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-xs text-gray-400">(opsional)</span></label>
                        <input type="password" name="password" id="password" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Perbarui</button>
                    <a href="{{ route('admin.wali-murid.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
