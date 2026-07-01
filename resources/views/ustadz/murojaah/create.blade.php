@extends('layouts.app')
@section('title', 'Input Murojaah')
@section('page-title', 'Input Murojaah Al-Quran')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('ustadz.murojaah.store') }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div>
                    <label for="santri_id" class="block text-sm font-medium text-gray-700 mb-1">Santri <span class="text-red-500">*</span></label>
                    <select name="santri_id" id="santri_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">-- Pilih Santri Binaan --</option>
                        @foreach($santriBinaan as $santri)
                            <option value="{{ $santri->id }}" {{ old('santri_id') == $santri->id ? 'selected' : '' }}>{{ $santri->nama }} ({{ $santri->nis }})</option>
                        @endforeach
                    </select>
                    @error('santri_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                    <div>
                        <label for="juz" class="block text-sm font-medium text-gray-700 mb-1">Juz <span class="text-red-500">*</span></label>
                        <select name="juz" id="juz" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            @for($i = 1; $i <= 30; $i++)
                                <option value="{{ $i }}" {{ old('juz') == $i ? 'selected' : '' }}>Juz {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="surat" class="block text-sm font-medium text-gray-700 mb-1">Surat <span class="text-red-500">*</span></label>
                        <input type="text" name="surat" id="surat" value="{{ old('surat') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Contoh: Al-Baqarah">
                    </div>
                    <div>
                        <label for="ayat" class="block text-sm font-medium text-gray-700 mb-1">Ayat <span class="text-red-500">*</span></label>
                        <input type="text" name="ayat" id="ayat" value="{{ old('ayat') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Contoh: 1-15">
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="nilai" class="block text-sm font-medium text-gray-700 mb-1">Nilai</label>
                        <input type="number" name="nilai" id="nilai" value="{{ old('nilai') }}" min="0" max="100" step="0.01" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="0 - 100">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Simpan</button>
                    <a href="{{ route('ustadz.murojaah.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
