@extends('layouts.app')
@section('title', 'Tambah Kegiatan')
@section('page-title', 'Tambah Kegiatan Pondok')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('admin.kegiatan.store') }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm"
                           placeholder="Contoh: Tahfidz, Tahsin, Kajian Kitab...">
                    @error('nama_kegiatan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tingkatan" class="block text-sm font-medium text-gray-700 mb-1">Tingkatan <span class="text-red-500">*</span></label>
                    <select name="tingkatan" id="tingkatan" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        @foreach(\App\Models\KegiatanPondok::TINGKATAN_OPTIONS as $key => $label)
                            <option value="{{ $key }}" {{ old('tingkatan', 'semua') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('tingkatan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm"
                              placeholder="Deskripsi kegiatan (opsional)">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Simpan</button>
                    <a href="{{ route('admin.kegiatan.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
