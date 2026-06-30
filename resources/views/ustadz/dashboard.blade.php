@extends('layouts.app')
@section('title', 'Dashboard Ustadz')
@section('page-title', 'Dashboard Ustadz')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_kegiatan_diampu'] }}</p>
                    <p class="text-sm text-gray-500">Kegiatan Diampu</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-50 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_santri_binaan'] }}</p>
                    <p class="text-sm text-gray-500">Santri Binaan</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-amber-50 text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['presensi_bulan_ini'] }}</p>
                    <p class="text-sm text-gray-500">Presensi Bulan Ini</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-purple-50 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['setoran_bulan_ini'] }}</p>
                    <p class="text-sm text-gray-500">Setoran Bulan Ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ route('ustadz.presensi-kegiatan.create') }}" class="flex items-center gap-4 p-5 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl text-white hover:from-emerald-600 hover:to-emerald-700 transition shadow-sm">
            <svg class="w-10 h-10 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <div>
                <p class="font-semibold">Presensi Kegiatan</p>
                <p class="text-sm text-emerald-100">Mulai presensi baru</p>
            </div>
        </a>
        <a href="{{ route('ustadz.setoran-hafalan.create') }}" class="flex items-center gap-4 p-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl text-white hover:from-blue-600 hover:to-blue-700 transition shadow-sm">
            <svg class="w-10 h-10 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <div>
                <p class="font-semibold">Input Setoran</p>
                <p class="text-sm text-blue-100">Catat hafalan santri</p>
            </div>
        </a>
        <a href="{{ route('ustadz.murojaah.create') }}" class="flex items-center gap-4 p-5 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl text-white hover:from-purple-600 hover:to-purple-700 transition shadow-sm">
            <svg class="w-10 h-10 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            <div>
                <p class="font-semibold">Input Murojaah</p>
                <p class="text-sm text-purple-100">Catat murojaah santri</p>
            </div>
        </a>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Presensi Terakhir</h3>
        @if($recentPresensi->count() > 0)
            <div class="space-y-3">
                @foreach($recentPresensi as $presensi)
                    <a href="{{ route('ustadz.presensi-kegiatan.show', $presensi) }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition">
                        <div>
                            <p class="font-medium text-gray-800">{{ $presensi->kegiatanPondok->nama_kegiatan }}</p>
                            <p class="text-sm text-gray-500">{{ $presensi->hari }}, {{ $presensi->tanggal->format('d M Y') }} • {{ $presensi->jam_mulai }}</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $presensi->status === 'valid' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($presensi->status) }}
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-400 text-center py-4">Belum ada riwayat presensi.</p>
        @endif
    </div>
</div>
@endsection
