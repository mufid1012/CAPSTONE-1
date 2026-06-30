@extends('layouts.app')
@section('title', 'Santri Binaan')
@section('page-title', 'Penugasan Santri Binaan ke Ustadz')

@section('content')
<div class="space-y-4">
    <p class="text-sm text-gray-500">Tentukan santri yang menjadi binaan setiap ustadz.</p>

    <!-- Filter -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.santri-binaan.index') }}" class="flex flex-col gap-3" x-data="{ tingkatan: '{{ $filterTingkatan }}', getKelasOptions() { if(this.tingkatan === 'tsanawiyah') return ['7', '8', '9']; if(this.tingkatan === 'aliyah') return ['10', '11', '12']; if(this.tingkatan === 'takhassus') return ['Takhassus']; return []; } }">
            <div class="w-full">
                <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Ustadz</label>
                <select name="ustadz_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    <option value="">-- Semua Ustadz --</option>
                    @foreach($allUstadz as $u)
                        <option value="{{ $u->id }}" {{ $selectedUstadzId == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full">
                <label class="block text-xs font-medium text-gray-500 mb-1">Filter Tingkatan Santri</label>
                <select name="tingkatan" x-model="tingkatan" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    <option value="">Semua Tingkatan</option>
                    @foreach(\App\Models\Santri::TINGKATAN_LABELS as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full" x-show="getKelasOptions().length > 0">
                <label class="block text-xs font-medium text-gray-500 mb-1">Filter Kelas</label>
                <select name="kelas" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    <option value="">Semua Kelas</option>
                    <template x-for="opt in getKelasOptions()" :key="opt">
                        <option :value="opt" x-text="opt" :selected="opt == '{{ request('kelas') }}'"></option>
                    </template>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">Filter</button>
                @if(request()->hasAny(['ustadz_id', 'tingkatan', 'kelas']))
                    <a href="{{ route('admin.santri-binaan.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Reset</a>
                @endif
            </div>
        </form>
    </div>

    @forelse($ustadzList as $ustadz)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <form action="{{ route('admin.santri-binaan.update', $ustadz) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <h4 class="font-semibold text-gray-800">{{ $ustadz->name }}</h4>
                    <p class="text-xs text-gray-400">{{ $ustadz->santriBinaan->count() }} santri binaan</p>
                </div>

                @php
                    $grouped = $santriList->groupBy('tingkatan');
                    $tingkatanOrder = ['tsanawiyah', 'aliyah', 'takhassus'];
                    $badgeColors = ['tsanawiyah' => 'text-blue-600', 'aliyah' => 'text-purple-600', 'takhassus' => 'text-amber-600'];
                @endphp

                @foreach($tingkatanOrder as $tingkatan)
                    @if(isset($grouped[$tingkatan]) && $grouped[$tingkatan]->count() > 0)
                        <div class="mb-3">
                            <p class="text-xs font-semibold uppercase tracking-wider mb-2 {{ $badgeColors[$tingkatan] ?? 'text-gray-500' }}">
                                {{ \App\Models\Santri::TINGKATAN_LABELS[$tingkatan] ?? $tingkatan }}
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-1.5">
                                @foreach($grouped[$tingkatan] as $santri)
                                    @php $isChecked = $ustadz->santriBinaan->contains($santri->id); @endphp
                                    <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border cursor-pointer transition text-sm
                                        {{ $isChecked ? 'border-purple-300 bg-purple-50 text-purple-700' : 'border-gray-200 hover:border-purple-200 text-gray-600' }}">
                                        <input type="checkbox" name="santri_ids[]" value="{{ $santri->id }}"
                                               {{ $isChecked ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                        {{ $santri->nama }}
                                        <span class="text-xs text-gray-400">({{ $santri->kelas ?: $santri->nis }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                <button type="submit" class="mt-2 px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">Simpan</button>
            </form>
        </div>
    @empty
        <div class="bg-white rounded-xl border border-gray-200 p-8 text-center text-gray-400">
            @if($selectedUstadzId)
                Ustadz tidak ditemukan.
            @else
                Belum ada ustadz.
            @endif
        </div>
    @endforelse
</div>
@endsection
