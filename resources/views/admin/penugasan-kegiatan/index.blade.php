@extends('layouts.app')
@section('title', 'Penugasan Ustadz → Kegiatan')
@section('page-title', 'Penugasan Ustadz ke Kegiatan Pondok')

@section('content')
<div class="space-y-4">
    <p class="text-sm text-gray-500">Tentukan kegiatan pondok yang diampu setiap ustadz.</p>

    <!-- Filter -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.penugasan-kegiatan.index') }}" class="flex flex-col gap-3">
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
                <label class="block text-xs font-medium text-gray-500 mb-1">Filter Tingkatan</label>
                <select name="tingkatan" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    <option value="semua">Semua Tingkatan</option>
                    @foreach(\App\Models\Santri::TINGKATAN_LABELS as $key => $label)
                        <option value="{{ $key }}" {{ request('tingkatan') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Filter</button>
                @if(request()->hasAny(['ustadz_id', 'tingkatan']))
                    <a href="{{ route('admin.penugasan-kegiatan.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Reset</a>
                @endif
            </div>
        </form>
    </div>

    @forelse($ustadzList as $ustadz)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <form action="{{ route('admin.penugasan-kegiatan.update', $ustadz) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <h4 class="font-semibold text-gray-800">{{ $ustadz->name }}</h4>
                    <p class="text-xs text-gray-400">{{ $ustadz->email }} • {{ $ustadz->kegiatanPondok->count() }} kegiatan ditugaskan</p>
                </div>
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($kegiatanList as $kegiatan)
                        @php
                            $badgeColors = ['semua' => 'border-gray-300', 'tsanawiyah' => 'border-blue-300', 'aliyah' => 'border-purple-300', 'takhassus' => 'border-amber-300'];
                            $checkedColors = ['semua' => 'border-gray-400 bg-gray-50', 'tsanawiyah' => 'border-blue-400 bg-blue-50', 'aliyah' => 'border-purple-400 bg-purple-50', 'takhassus' => 'border-amber-400 bg-amber-50'];
                            $isChecked = $ustadz->kegiatanPondok->contains($kegiatan->id);
                        @endphp
                        <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border cursor-pointer transition text-sm
                            {{ $isChecked ? ($checkedColors[$kegiatan->tingkatan] ?? 'border-emerald-300 bg-emerald-50') . ' text-gray-800' : ($badgeColors[$kegiatan->tingkatan] ?? 'border-gray-200') . ' hover:bg-gray-50 text-gray-600' }}">
                            <input type="checkbox" name="kegiatan_ids[]" value="{{ $kegiatan->id }}"
                                   {{ $isChecked ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            {{ $kegiatan->nama_kegiatan }}
                            <span class="text-xs text-gray-400">({{ $kegiatan->tingkatan_label }})</span>
                        </label>
                    @endforeach
                </div>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Simpan</button>
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
