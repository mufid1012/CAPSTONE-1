@extends('layouts.app')
@section('title', 'Laporan Setoran Hafalan')
@section('page-title', 'Laporan Setoran Hafalan')

@section('content')
<div class="space-y-6">
    <!-- Filter Section -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.laporan.hafalan') }}" class="flex flex-col gap-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Bulan & Tahun</label>
                    <input type="month" name="bulan" value="{{ request('bulan') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
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
                    <label class="block text-xs font-medium text-gray-500 mb-1">Pengampu (Ustadz)</label>
                    <select name="ustadz_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">-- Semua Ustadz --</option>
                        @foreach($allUstadz as $ustadz)
                            <option value="{{ $ustadz->id }}" {{ request('ustadz_id') == $ustadz->id ? 'selected' : '' }}>{{ $ustadz->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-5 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Terapkan Filter</button>
                @if(request()->anyFilled(['bulan', 'tingkatan', 'santri_id', 'ustadz_id']))
                    <a href="{{ route('admin.laporan.hafalan') }}" class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Reset</a>
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
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Santri</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tingkatan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Juz/Surat/Ayat</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Nilai</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Pengampu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($hafalanList as $hafalan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-800">{{ \Carbon\Carbon::parse($hafalan->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ optional($hafalan->santri)->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ optional($hafalan->santri)->tingkatan_label ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                <div>Juz {{ $hafalan->juz }}</div>
                                <div class="text-xs text-gray-500">{{ $hafalan->surat }} (Ayat {{ $hafalan->ayat }})</div>
                            </td>
                            <td class="px-4 py-3 text-center font-semibold text-gray-800">{{ $hafalan->nilai }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ optional($hafalan->ustadz)->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                @if(request()->anyFilled(['bulan', 'tingkatan', 'santri_id', 'ustadz_id']))
                                    Tidak ada data hafalan yang sesuai dengan filter.
                                @else
                                    Belum ada data setoran hafalan.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($hafalanList->hasPages())
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $hafalanList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
