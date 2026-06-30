@extends('layouts.app')
@section('title', 'Detail Ustadz')
@section('page-title', 'Detail Ustadz')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xl">
                    {{ substr($ustadz->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $ustadz->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $ustadz->email }}</p>
                </div>
            </div>
            <a href="{{ route('admin.ustadz.edit', $ustadz) }}" class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition">Edit</a>
        </div>
    </div>

    <!-- Kegiatan yang Diampu -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">📋 Kegiatan yang Diampu</h4>
        @if($ustadz->kegiatanPondok->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($ustadz->kegiatanPondok as $kegiatan)
                    @php
                        $badgeColors = ['semua' => 'bg-gray-100 text-gray-700', 'tsanawiyah' => 'bg-blue-100 text-blue-700', 'aliyah' => 'bg-purple-100 text-purple-700', 'takhassus' => 'bg-amber-100 text-amber-700'];
                    @endphp
                    <a href="{{ route('admin.kegiatan.show', $kegiatan) }}" class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50/50 transition">
                        <span class="font-medium text-gray-800">{{ $kegiatan->nama_kegiatan }}</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColors[$kegiatan->tingkatan] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $kegiatan->tingkatan_label }}
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-400 text-center py-4">Belum ada kegiatan yang ditugaskan.</p>
        @endif
    </div>

    <!-- Santri Binaan -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">👨‍🎓 Santri Binaan ({{ $ustadz->santriBinaan->count() }})</h4>
        @if($ustadz->santriBinaan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">No</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">NIS</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">Nama</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">Tingkatan</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">Kelas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($ustadz->santriBinaan as $index => $santri)
                            @php $badgeColors2 = ['tsanawiyah' => 'bg-blue-100 text-blue-700', 'aliyah' => 'bg-purple-100 text-purple-700', 'takhassus' => 'bg-amber-100 text-amber-700']; @endphp
                            <tr>
                                <td class="px-4 py-2 text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 font-mono text-gray-500">{{ $santri->nis }}</td>
                                <td class="px-4 py-2 font-medium text-gray-800">{{ $santri->nama }}</td>
                                <td class="px-4 py-2"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $badgeColors2[$santri->tingkatan] ?? 'bg-gray-100 text-gray-700' }}">{{ $santri->tingkatan_label }}</span></td>
                                <td class="px-4 py-2 text-gray-500">{{ $santri->kelas ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-400 text-center py-4">Belum ada santri binaan.</p>
        @endif
    </div>

    <div class="pt-2">
        <a href="{{ route('admin.ustadz.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">← Kembali</a>
    </div>
</div>
@endsection
