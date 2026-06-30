@extends('layouts.app')
@section('title', 'Laporan Presensi Santri')
@section('page-title', 'Laporan Presensi Santri')

@section('content')
<div class="space-y-6">
    <!-- Filter Section -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.laporan.presensi-santri') }}" class="flex flex-col gap-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Bulan & Tahun</label>
                    <input type="month" name="bulan" value="{{ request('bulan') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
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
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tingkatan</label>
                    <select name="tingkatan" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="semua">-- Semua Tingkatan --</option>
                        @foreach(\App\Models\Santri::TINGKATAN_LABELS as $key => $label)
                            <option value="{{ $key }}" {{ request('tingkatan') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Santri</label>
                    <select name="santri_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">-- Semua Santri --</option>
                        @foreach($allSantri as $santri)
                            <option value="{{ $santri->id }}" {{ request('santri_id') == $santri->id ? 'selected' : '' }}>{{ $santri->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status Kehadiran</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">-- Semua Status --</option>
                        <option value="hadir" {{ request('status') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ request('status') === 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ request('status') === 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alpha" {{ request('status') === 'alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-5 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Terapkan Filter</button>
                @if(request()->anyFilled(['bulan', 'kegiatan_pondok_id', 'tingkatan', 'santri_id', 'status']))
                    <a href="{{ route('admin.laporan.presensi-santri') }}" class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Reset</a>
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
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Kegiatan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Santri</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tingkatan</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($presensiList as $index => $ps)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $presensiList->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ \Carbon\Carbon::parse(optional($ps->presensiKegiatan)->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ optional(optional($ps->presensiKegiatan)->kegiatanPondok)->nama_kegiatan ?? '-' }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ optional($ps->santri)->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ optional($ps->santri)->tingkatan_label ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $statusColors = [
                                        'hadir' => 'bg-emerald-100 text-emerald-800',
                                        'izin'  => 'bg-blue-100 text-blue-800',
                                        'sakit' => 'bg-amber-100 text-amber-800',
                                        'alpha' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$ps->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($ps->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                @if(request()->anyFilled(['bulan', 'kegiatan_pondok_id', 'tingkatan', 'santri_id', 'status']))
                                    Tidak ada data presensi santri yang sesuai dengan filter.
                                @else
                                    Belum ada data presensi santri.
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
