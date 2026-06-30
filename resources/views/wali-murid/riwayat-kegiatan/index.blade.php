@extends('layouts.app')
@section('title', 'Riwayat Kegiatan')
@section('page-title', 'Riwayat Kegiatan Santri')

@section('content')
<div class="space-y-4">
    <!-- Filter -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <form method="GET" action="{{ route('wali-murid.riwayat-kegiatan.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Anak</label>
                <select name="santri_id" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    @foreach($santriList as $santri)
                        <option value="{{ $santri->id }}" {{ $selectedSantriId == $santri->id ? 'selected' : '' }}>{{ $santri->nama }} ({{ $santri->nis }})</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Riwayat Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Kegiatan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Ustadz</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-600">
                                {{ $item->presensiKegiatan->hari }}, {{ $item->presensiKegiatan->tanggal->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $item->presensiKegiatan->kegiatanPondok->nama_kegiatan }}
                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                {{ $item->presensiKegiatan->ustadz->name }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $colors = ['hadir' => 'bg-emerald-100 text-emerald-700', 'izin' => 'bg-blue-100 text-blue-700', 'sakit' => 'bg-amber-100 text-amber-700', 'alpha' => 'bg-red-100 text-red-700'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat kegiatan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($riwayat instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">{{ $riwayat->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
