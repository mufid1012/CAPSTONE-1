@extends('layouts.app')
@section('title', 'Murojaah')
@section('page-title', 'Murojaah Al-Quran')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <p class="text-sm text-gray-500">Pilih santri binaan untuk melihat riwayat murojaah.</p>
        <a href="{{ route('ustadz.murojaah.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Input Murojaah
        </a>
    </div>

    <!-- Pilih Santri -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <form method="GET" action="{{ route('ustadz.murojaah.index') }}" class="flex flex-col gap-3">
            <div class="w-full">
                <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Jenjang Pendidikan</label>
                <select name="tingkatan" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    <option value="">-- Semua Jenjang --</option>
                    @foreach(\App\Models\Santri::TINGKATAN_LABELS as $key => $label)
                        <option value="{{ $key }}" {{ request('tingkatan') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full">
                <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Santri Binaan</label>
                <select name="santri_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    <option value="">-- Pilih Santri --</option>
                    @foreach($santriBinaan as $santri)
                        <option value="{{ $santri->id }}" {{ $selectedSantriId == $santri->id ? 'selected' : '' }}>{{ $santri->nama }} ({{ $santri->nis }} — {{ $santri->tingkatan_label }})</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Tampilkan</button>
            </div>
        </form>
    </div>

    @if(!$selectedSantriId)
        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            <p class="text-gray-400 text-sm">Pilih santri terlebih dahulu untuk melihat riwayat murojaah.</p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200"><tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Juz</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Surat & Ayat</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Nilai</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($murojaahList as $m)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-600">{{ $m->tanggal->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-gray-600">Juz {{ $m->juz }}</td>
                                <td class="px-4 py-3 text-gray-800">{{ $m->surat }} : {{ $m->ayat }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-gray-800">{{ $m->nilai ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat murojaah untuk santri ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($murojaahList instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-4">{{ $murojaahList->links() }}</div>
        @endif
    @endif
</div>
@endsection
