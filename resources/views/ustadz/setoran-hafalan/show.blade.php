@extends('layouts.app')
@section('title', 'Detail Setoran')
@section('page-title', 'Detail Setoran Hafalan')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="grid grid-cols-2 gap-4">
            <div><p class="text-xs text-gray-400 uppercase">Santri</p><p class="font-semibold text-gray-800 mt-1">{{ $setoranHafalan->santri->nama }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Tanggal</p><p class="font-semibold text-gray-800 mt-1">{{ $setoranHafalan->tanggal->format('d M Y') }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Juz</p><p class="font-semibold text-gray-800 mt-1">{{ $setoranHafalan->juz }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Surat & Ayat</p><p class="font-semibold text-gray-800 mt-1">{{ $setoranHafalan->surat }} : {{ $setoranHafalan->ayat }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Nilai</p><p class="font-semibold text-gray-800 mt-1">{{ $setoranHafalan->nilai ?? '-' }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Status</p><span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $setoranHafalan->status_selesai ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $setoranHafalan->status_selesai ? 'Selesai' : 'Proses' }}</span></div>
        </div>
        @if($setoranHafalan->catatan)
            <div class="mt-4 pt-4 border-t border-gray-100"><p class="text-xs text-gray-400 uppercase">Catatan</p><p class="text-sm text-gray-600 mt-1">{{ $setoranHafalan->catatan }}</p></div>
        @endif
        <div class="mt-6 pt-4 border-t border-gray-100">
            <a href="{{ route('ustadz.setoran-hafalan.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Kembali</a>
        </div>
    </div>
</div>
@endsection
