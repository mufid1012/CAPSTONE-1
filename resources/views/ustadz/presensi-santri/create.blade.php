@extends('layouts.app')
@section('title', 'Presensi Santri')
@section('page-title', 'Presensi Santri')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="mb-5 pb-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">{{ $presensiKegiatan->kegiatanPondok->nama_kegiatan }}</h3>
            <p class="text-sm text-gray-500">{{ $presensiKegiatan->hari }}, {{ $presensiKegiatan->tanggal->format('d M Y') }} • {{ $presensiKegiatan->jam_mulai }}</p>
        </div>

        <form action="{{ route('ustadz.presensi-santri.store', $presensiKegiatan) }}" method="POST">
            @csrf
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">NIS</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Santri</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Hadir</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Izin</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Sakit</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Alpha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($santriList as $index => $santri)
                        @php $currentStatus = $existingPresensi[$santri->id] ?? 'hadir'; @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-mono text-gray-500">{{ $santri->nis }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $santri->nama }}</td>
                            <input type="hidden" name="presensi[{{ $index }}][santri_id]" value="{{ $santri->id }}">
                            @foreach(['hadir', 'izin', 'sakit', 'alpha'] as $status)
                                <td class="px-4 py-3 text-center">
                                    <input type="radio" name="presensi[{{ $index }}][status]" value="{{ $status }}"
                                           {{ $currentStatus === $status ? 'checked' : '' }}
                                           class="text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex items-center gap-3 pt-5 mt-5 border-t border-gray-100">
                <button type="submit" class="px-5 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Simpan Presensi</button>
                <a href="{{ route('ustadz.presensi-kegiatan.show', $presensiKegiatan) }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
