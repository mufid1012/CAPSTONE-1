@extends('layouts.app')
@section('title', 'Edit Kegiatan')
@section('page-title', 'Edit Kegiatan Pondok')

@section('content')
<div class="max-w-2xl" x-data="{
    tingkatan: '{{ old('tingkatan', $kegiatan->tingkatan) }}',
    kelasOptions: @js(\App\Models\KegiatanPondok::KELAS_OPTIONS),
    get availableKelas() {
        return this.kelasOptions[this.tingkatan] || [];
    }
}">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('admin.kegiatan.update', $kegiatan) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div>
                    <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>

                <div>
                    <label for="tingkatan" class="block text-sm font-medium text-gray-700 mb-1">Tingkatan <span class="text-red-500">*</span></label>
                    <select name="tingkatan" id="tingkatan" required x-model="tingkatan"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        @foreach(\App\Models\KegiatanPondok::TINGKATAN_OPTIONS as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div x-show="tingkatan !== 'semua'" x-transition>
                    <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="kelas" id="kelas" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">-- Semua Kelas --</option>
                        <template x-for="k in availableKelas" :key="k">
                            <option :value="k" x-text="'Kelas ' + k" :selected="k === '{{ old('kelas', $kegiatan->kelas) }}'"></option>
                        </template>
                    </select>
                    <p class="mt-1 text-xs text-gray-400">Kosongkan jika kegiatan untuk semua kelas di tingkatan ini.</p>
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Perbarui</button>
                    <a href="{{ route('admin.kegiatan.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
