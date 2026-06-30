@extends('layouts.app')
@section('title', 'Dashboard Wali Murid')
@section('page-title', 'Dashboard Wali Murid')

@section('content')
<div class="space-y-6">
    @if($santriList->isEmpty())
        <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <p class="text-gray-500">Belum ada data santri yang terhubung dengan akun Anda.</p>
            <p class="text-sm text-gray-400 mt-1">Hubungi admin untuk menghubungkan data anak Anda.</p>
        </div>
    @else
        <p class="text-sm text-gray-500">Ringkasan perkembangan putra/putri Anda.</p>

        @foreach($ringkasan as $data)
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 font-bold text-lg">
                        {{ substr($data['santri']->nama, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">{{ $data['santri']->nama }}</h3>
                        <p class="text-sm text-gray-500">NIS: {{ $data['santri']->nis }} • Kelas: {{ $data['santri']->kelas ?: '-' }} • {{ $data['santri']->tingkatan_label }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="bg-blue-50 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-blue-700">{{ $data['total_setoran'] }}</p>
                        <p class="text-xs text-blue-500 mt-0.5">Total Setoran</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-purple-700">{{ $data['total_murojaah'] }}</p>
                        <p class="text-xs text-purple-500 mt-0.5">Total Murojaah</p>
                    </div>
                    <div class="bg-emerald-50 rounded-lg p-3 text-center">
                        <p class="text-sm font-semibold text-emerald-700">{{ $data['last_setoran'] ? $data['last_setoran']->surat . ' : ' . $data['last_setoran']->ayat : '-' }}</p>
                        <p class="text-xs text-emerald-500 mt-0.5">Setoran Terakhir</p>
                    </div>
                    <div class="bg-amber-50 rounded-lg p-3 text-center">
                        <p class="text-sm font-semibold text-amber-700">{{ $data['last_murojaah'] ? $data['last_murojaah']->surat . ' : ' . $data['last_murojaah']->ayat : '-' }}</p>
                        <p class="text-xs text-amber-500 mt-0.5">Murojaah Terakhir</p>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('wali-murid.laporan-mingguan.index') }}" class="flex items-center gap-4 p-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl text-white hover:from-blue-600 hover:to-blue-700 transition shadow-sm">
                <svg class="w-10 h-10 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <div>
                    <p class="font-semibold">Laporan Mingguan</p>
                    <p class="text-sm text-blue-100">Rekap hafalan & murojaah per minggu</p>
                </div>
            </a>
            <a href="{{ route('wali-murid.riwayat-kegiatan.index') }}" class="flex items-center gap-4 p-5 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl text-white hover:from-emerald-600 hover:to-emerald-700 transition shadow-sm">
                <svg class="w-10 h-10 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <p class="font-semibold">Riwayat Kegiatan</p>
                    <p class="text-sm text-emerald-100">Daftar kegiatan yang diikuti</p>
                </div>
            </a>
        </div>
    @endif
</div>
@endsection
