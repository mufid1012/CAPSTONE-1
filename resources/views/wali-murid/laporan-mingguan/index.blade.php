@extends('layouts.app')
@section('title', 'Laporan Mingguan')
@section('page-title', 'Laporan Mingguan')

@section('content')
<div class="space-y-4">
    <!-- Filters -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <form method="GET" action="{{ route('wali-murid.laporan-mingguan.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Anak</label>
                <select name="santri_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    @foreach($santriList as $santri)
                        <option value="{{ $santri->id }}" {{ $selectedSantriId == $santri->id ? 'selected' : '' }}>{{ $santri->nama }} ({{ $santri->nis }})</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 mb-1">Minggu (Tanggal Mulai)</label>
                <input type="date" name="minggu" value="{{ $selectedWeek }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Tampilkan</button>
            </div>
        </form>
    </div>

    <div class="text-sm text-gray-500">
        Periode: <span class="font-medium text-gray-700">{{ $weekStart->format('d M') }} — {{ $weekEnd->format('d M Y') }}</span>
    </div>

    <!-- Setoran Hafalan -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">📖 Setoran Hafalan</h3>
        @if(count($setoran) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200"><tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Juz</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Surat & Ayat</th>
                        <th class="px-4 py-2 text-center font-semibold text-gray-600">Nilai</th>
                        <th class="px-4 py-2 text-center font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Ustadz</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($setoran as $s)
                            <tr>
                                <td class="px-4 py-2 text-gray-600">{{ $s->tanggal->format('d M') }}</td>
                                <td class="px-4 py-2 text-gray-600">Juz {{ $s->juz }}</td>
                                <td class="px-4 py-2 text-gray-800">{{ $s->surat }} : {{ $s->ayat }}</td>
                                <td class="px-4 py-2 text-center font-semibold">{{ $s->nilai ?? '-' }}</td>
                                <td class="px-4 py-2 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $s->status_selesai ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $s->status_selesai ? 'Selesai' : 'Proses' }}</span></td>
                                <td class="px-4 py-2 text-gray-500">{{ $s->ustadz->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-400 text-center py-4">Tidak ada setoran hafalan pada minggu ini.</p>
        @endif
    </div>

    <!-- Murojaah -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">🔄 Murojaah</h3>
        @if(count($murojaah) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200"><tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Juz</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Surat & Ayat</th>
                        <th class="px-4 py-2 text-center font-semibold text-gray-600">Nilai</th>
                        <th class="px-4 py-2 text-center font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Ustadz</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($murojaah as $m)
                            <tr>
                                <td class="px-4 py-2 text-gray-600">{{ $m->tanggal->format('d M') }}</td>
                                <td class="px-4 py-2 text-gray-600">Juz {{ $m->juz }}</td>
                                <td class="px-4 py-2 text-gray-800">{{ $m->surat }} : {{ $m->ayat }}</td>
                                <td class="px-4 py-2 text-center font-semibold">{{ $m->nilai ?? '-' }}</td>
                                <td class="px-4 py-2 text-center"><span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $m->status_selesai ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $m->status_selesai ? 'Selesai' : 'Proses' }}</span></td>
                                <td class="px-4 py-2 text-gray-500">{{ $m->ustadz->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-400 text-center py-4">Tidak ada murojaah pada minggu ini.</p>
        @endif
    </div>
</div>
@endsection
