@extends('layouts.app')
@section('title', 'Laporan Presensi Ustadz')
@section('page-title', 'Laporan Presensi Ustadz')

@section('content')
<div class="space-y-6">
    <!-- Filter Section -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.laporan.presensi-ustadz') }}" class="flex flex-col gap-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Bulan & Tahun</label>
                    <input type="month" name="bulan" value="{{ request('bulan') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Ustadz</label>
                    <select name="ustadz_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">-- Semua Ustadz --</option>
                        @foreach($allUstadz as $ustadz)
                            <option value="{{ $ustadz->id }}" {{ request('ustadz_id') == $ustadz->id ? 'selected' : '' }}>{{ $ustadz->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Kegiatan Pondok</label>
                    <select name="kegiatan_pondok_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">-- Semua Kegiatan --</option>
                        @foreach($allKegiatan as $kegiatan)
                            <option value="{{ $kegiatan->id }}" {{ request('kegiatan_pondok_id') == $kegiatan->id ? 'selected' : '' }}>{{ $kegiatan->nama_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-5 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Terapkan Filter</button>
                @if(request()->anyFilled(['bulan', 'ustadz_id', 'kegiatan_pondok_id']))
                    <a href="{{ route('admin.laporan.presensi-ustadz') }}" class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Section -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal & Jam</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Ustadz</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Kegiatan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Materi</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($presensiList as $index => $presensi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $presensiList->firstItem() + $index }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($presensi->jam_mulai)->format('H:i') }} - {{ $presensi->jam_selesai ? \Carbon\Carbon::parse($presensi->jam_selesai)->format('H:i') : 'Selesai' }}</div>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ optional($presensi->ustadz)->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ optional($presensi->kegiatanPondok)->nama_kegiatan ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ \Illuminate\Support\Str::limit($presensi->materi, 30) ?: '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($presensi->status === 'valid')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Valid</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Invalid</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                @if(request()->anyFilled(['bulan', 'ustadz_id', 'kegiatan_pondok_id']))
                                    Tidak ada data presensi ustadz yang sesuai dengan filter.
                                @else
                                    Belum ada data presensi ustadz.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($presensiList->hasPages())
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $presensiList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
