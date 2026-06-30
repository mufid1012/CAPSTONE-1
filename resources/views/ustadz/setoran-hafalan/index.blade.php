@extends('layouts.app')
@section('title', 'Setoran Hafalan')
@section('page-title', 'Setoran Hafalan')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <p class="text-sm text-gray-500">Pilih santri binaan untuk melihat riwayat setoran hafalan.</p>
        <a href="{{ route('ustadz.setoran-hafalan.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Input Setoran
        </a>
    </div>

    <!-- Pilih Santri -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <form method="GET" action="{{ route('ustadz.setoran-hafalan.index') }}" class="flex flex-col gap-3">
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
        <!-- Empty state: no santri selected -->
        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <p class="text-gray-400 text-sm">Pilih santri terlebih dahulu untuk melihat riwayat setoran hafalan.</p>
        </div>
    @else
        <!-- Riwayat Setoran -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200"><tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Juz</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Surat & Ayat</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Nilai</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Catatan</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($setoranList as $s)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-600">{{ $s->tanggal->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-gray-600">Juz {{ $s->juz }}</td>
                                <td class="px-4 py-3 text-gray-800">{{ $s->surat }} : {{ $s->ayat }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-gray-800">{{ $s->nilai ?? '-' }}</td>
                                <td class="px-4 py-3 text-center"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s->status_selesai ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $s->status_selesai ? 'Selesai' : 'Proses' }}</span></td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ Str::limit($s->catatan, 30) ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat setoran untuk santri ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($setoranList instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-4">{{ $setoranList->links() }}</div>
        @endif
    @endif
</div>
@endsection
