@extends('layouts.app')
@section('title', 'Detail Kegiatan')
@section('page-title', 'Detail Kegiatan Pondok')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ $kegiatan->nama_kegiatan }}</h3>
                @php
                    $badgeColors = ['semua' => 'bg-gray-100 text-gray-700', 'tsanawiyah' => 'bg-blue-100 text-blue-700', 'aliyah' => 'bg-purple-100 text-purple-700', 'takhassus' => 'bg-amber-100 text-amber-700'];
                @endphp
                <span class="inline-flex items-center mt-2 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColors[$kegiatan->tingkatan] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $kegiatan->tingkatan_label }}
                </span>
            </div>
            <a href="{{ route('admin.kegiatan.edit', $kegiatan) }}" class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition">Edit</a>
        </div>
        @if($kegiatan->deskripsi)
            <p class="mt-3 text-sm text-gray-600">{{ $kegiatan->deskripsi }}</p>
        @endif
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Ustadz yang Mengampu</h4>
        @if($kegiatan->ustadz->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($kegiatan->ustadz as $u)
                    <a href="{{ route('admin.ustadz.show', $u) }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50/50 transition">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm">
                            {{ substr($u->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-medium text-gray-800 truncate">{{ $u->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $u->email }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-400 text-center py-4">Belum ada ustadz yang ditugaskan.</p>
        @endif
    </div>

    <div class="pt-2">
        <a href="{{ route('admin.kegiatan.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">← Kembali</a>
    </div>
</div>
@endsection
