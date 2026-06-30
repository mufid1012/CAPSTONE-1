@extends('layouts.app')
@section('title', 'Presensi Kegiatan')
@section('page-title', 'Presensi Kegiatan Pondok')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="mb-5 pb-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Form Kegiatan & Presensi Diri</h3>
            <p class="text-sm text-gray-500 mt-1">Isi data kegiatan, lalu tekan tombol presensi untuk validasi lokasi.</p>
        </div>

        <form id="presensiForm" action="{{ route('ustadz.presensi-kegiatan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

            <div class="space-y-5">
                <div>
                    <label for="kegiatan_pondok_id" class="block text-sm font-medium text-gray-700 mb-1">Kegiatan Pondok <span class="text-red-500">*</span></label>
                    <select name="kegiatan_pondok_id" id="kegiatan_pondok_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">-- Pilih Kegiatan --</option>
                        @foreach($kegiatanDiampu as $kegiatan)
                            <option value="{{ $kegiatan->id }}" {{ old('kegiatan_pondok_id') == $kegiatan->id ? 'selected' : '' }}>{{ $kegiatan->nama_kegiatan }}</option>
                        @endforeach
                    </select>
                    @error('kegiatan_pondok_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="materi" class="block text-sm font-medium text-gray-700 mb-1">Materi / Agenda</label>
                    <textarea name="materi" id="materi" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Materi yang akan disampaikan...">{{ old('materi') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        @error('jam_mulai') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                </div>

                <!-- Geolocation Status -->
                <div id="geoStatus" class="p-4 rounded-lg border border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div id="geoIcon" class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p id="geoText" class="text-sm font-medium text-gray-500">Lokasi belum diambil</p>
                            <p id="geoCoords" class="text-xs text-gray-400"></p>
                        </div>
                    </div>
                </div>
                @error('geolocation') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                @error('latitude') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

                <div class="pt-4 border-t border-gray-100">
                    <button type="button" id="presensiBtn" onclick="getLocationAndSubmit()"
                            class="w-full flex items-center justify-center gap-3 px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-semibold rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition shadow-sm text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span id="btnText">Presensi Sekarang</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function getLocationAndSubmit() {
    const btn = document.getElementById('presensiBtn');
    const btnText = document.getElementById('btnText');
    const geoIcon = document.getElementById('geoIcon');
    const geoText = document.getElementById('geoText');
    const geoCoords = document.getElementById('geoCoords');
    const geoStatus = document.getElementById('geoStatus');

    if (!navigator.geolocation) {
        alert('Browser Anda tidak mendukung Geolocation. Gunakan browser modern seperti Chrome atau Firefox.');
        return;
    }

    // Validate form first
    const form = document.getElementById('presensiForm');
    const kegiatan = document.getElementById('kegiatan_pondok_id');
    const jamMulai = document.getElementById('jam_mulai');

    if (!kegiatan.value || !jamMulai.value) {
        alert('Silakan isi kegiatan dan jam mulai terlebih dahulu.');
        return;
    }

    // Show loading state
    btn.disabled = true;
    btnText.textContent = 'Mengambil lokasi...';
    geoText.textContent = 'Mengambil lokasi...';
    geoIcon.className = 'flex items-center justify-center w-10 h-10 rounded-full bg-amber-100 text-amber-500 animate-pulse';
    geoStatus.className = 'p-4 rounded-lg border border-amber-200 bg-amber-50';

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Show success
            geoText.textContent = 'Lokasi berhasil diambil!';
            geoCoords.textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
            geoIcon.className = 'flex items-center justify-center w-10 h-10 rounded-full bg-emerald-100 text-emerald-500';
            geoStatus.className = 'p-4 rounded-lg border border-emerald-200 bg-emerald-50';

            // Submit form
            form.submit();
        },
        function(error) {
            btn.disabled = false;
            btnText.textContent = 'Presensi Sekarang';

            let message = '';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    message = 'Izin lokasi ditolak. Aktifkan izin lokasi di pengaturan browser Anda.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    message = 'Informasi lokasi tidak tersedia. Pastikan GPS aktif.';
                    break;
                case error.TIMEOUT:
                    message = 'Waktu pengambilan lokasi habis. Coba lagi.';
                    break;
                default:
                    message = 'Terjadi kesalahan saat mengambil lokasi.';
            }

            geoText.textContent = message;
            geoIcon.className = 'flex items-center justify-center w-10 h-10 rounded-full bg-red-100 text-red-500';
            geoStatus.className = 'p-4 rounded-lg border border-red-200 bg-red-50';
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}
</script>
@endsection
