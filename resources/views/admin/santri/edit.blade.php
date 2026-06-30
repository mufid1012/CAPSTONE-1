@extends('layouts.app')
@section('title', 'Edit Santri')
@section('page-title', 'Edit Data Santri')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('admin.santri.update', $santri) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Santri <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $santri->nama) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">NIS <span class="text-red-500">*</span></label>
                        <input type="text" name="nis" id="nis" value="{{ old('nis', $santri->nis) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" x-data="{ tingkatan: '{{ old('tingkatan', $santri->tingkatan) }}', getKelasOptions() { if(this.tingkatan === 'tsanawiyah') return ['7', '8', '9']; if(this.tingkatan === 'aliyah') return ['10', '11', '12']; return ['Takhassus']; } }">
                    <div>
                        <label for="tingkatan" class="block text-sm font-medium text-gray-700 mb-1">Tingkatan <span class="text-red-500">*</span></label>
                        <select name="tingkatan" id="tingkatan" x-model="tingkatan" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            @foreach(\App\Models\Santri::TINGKATAN_LABELS as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="kelas" id="kelas" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <template x-for="opt in getKelasOptions()" :key="opt">
                                <option :value="opt" x-text="opt" :selected="opt == '{{ old('kelas', $santri->kelas) }}'"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $santri->tanggal_lahir?->format('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                </div>
                <div>
                    <label for="wali_murid_id" class="block text-sm font-medium text-gray-700 mb-1">Wali Murid</label>
                    <select name="wali_murid_id" id="wali_murid_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">-- Pilih Wali Murid --</option>
                        @foreach($waliMuridList as $wali)
                            <option value="{{ $wali->id }}" {{ old('wali_murid_id', $santri->wali_murid_id) == $wali->id ? 'selected' : '' }}>{{ $wali->name }} ({{ $wali->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Perbarui</button>
                    <a href="{{ route('admin.santri.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
