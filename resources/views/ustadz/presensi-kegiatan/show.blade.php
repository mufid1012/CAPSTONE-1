@extends('layouts.app')
@section('title', 'Detail Presensi')
@section('page-title', 'Detail Presensi Kegiatan')

@section('content')
<div class="space-y-6">
    <!-- Presensi Info -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Kegiatan</p>
                <p class="font-semibold text-gray-800 mt-1">{{ $presensiKegiatan->kegiatanPondok->nama_kegiatan }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Tanggal</p>
                <p class="font-semibold text-gray-800 mt-1">{{ $presensiKegiatan->hari }}, {{ $presensiKegiatan->tanggal->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Jam</p>
                <p class="font-semibold text-gray-800 mt-1">{{ $presensiKegiatan->jam_mulai }}{{ $presensiKegiatan->jam_selesai ? ' - ' . $presensiKegiatan->jam_selesai : '' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Status</p>
                <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $presensiKegiatan->status === 'valid' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($presensiKegiatan->status) }}
                </span>
            </div>
        </div>
        @if($presensiKegiatan->materi)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-400 uppercase tracking-wider">Materi</p>
                <p class="text-sm text-gray-600 mt-1">{{ $presensiKegiatan->materi }}</p>
            </div>
        @endif
    </div>

    <!-- Presensi Santri -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Presensi Santri</h3>
            @if($presensiKegiatan->isValid())
                <a href="{{ route('ustadz.presensi-santri.create', $presensiKegiatan) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    {{ $presensiKegiatan->presensiSantri->count() > 0 ? 'Edit Presensi' : 'Isi Presensi' }}
                </a>
            @endif
        </div>

        @if($presensiKegiatan->presensiSantri->count() > 0)
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">No</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Nama Santri</th>
                        <th class="px-4 py-2 text-center font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($presensiKegiatan->presensiSantri as $index => $ps)
                        <tr>
                            <td class="px-4 py-2 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 text-gray-800">{{ $ps->santri->nama }}</td>
                            <td class="px-4 py-2 text-center">
                                @php
                                    $colors = ['hadir' => 'bg-emerald-100 text-emerald-700', 'izin' => 'bg-blue-100 text-blue-700', 'sakit' => 'bg-amber-100 text-amber-700', 'alpha' => 'bg-red-100 text-red-700'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$ps->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($ps->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-sm text-gray-400 text-center py-4">
                @if($presensiKegiatan->isValid())
                    Belum ada data presensi santri. <a href="{{ route('ustadz.presensi-santri.create', $presensiKegiatan) }}" class="text-emerald-600 hover:underline">Isi sekarang</a>.
                @else
                    Presensi belum tervalidasi. Presensi santri tidak dapat diisi.
                @endif
            </p>
        @endif
    </div>
</div>
@endsection
