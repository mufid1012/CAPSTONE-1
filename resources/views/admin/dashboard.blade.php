@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-50 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_santri'] }}</p>
                    <p class="text-sm text-gray-500">Total Santri</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_ustadz'] }}</p>
                    <p class="text-sm text-gray-500">Total Ustadz</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-purple-50 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_kegiatan'] }}</p>
                    <p class="text-sm text-gray-500">Kegiatan Pondok</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-amber-50 text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['presensi_hari_ini'] }}</p>
                    <p class="text-sm text-gray-500">Presensi Hari Ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="{{ route('admin.santri.create') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 transition text-center">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span class="text-sm font-medium text-gray-700">Tambah Santri</span>
            </a>
            <a href="{{ route('admin.ustadz.create') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 transition text-center">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span class="text-sm font-medium text-gray-700">Tambah Ustadz</span>
            </a>
            <a href="{{ route('admin.kegiatan.create') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 transition text-center">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span class="text-sm font-medium text-gray-700">Tambah Kegiatan</span>
            </a>
            <a href="{{ route('admin.penugasan-kegiatan.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-lg border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 transition text-center">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                <span class="text-sm font-medium text-gray-700">Penugasan</span>
            </a>
        </div>
    </div>
</div>
@endsection
