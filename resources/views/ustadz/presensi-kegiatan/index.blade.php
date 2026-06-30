@extends('layouts.app')
@section('title', 'Riwayat Presensi')
@section('page-title', 'Riwayat Presensi Kegiatan')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">Riwayat presensi kegiatan pondok Anda.</p>
        <a href="{{ route('ustadz.presensi-kegiatan.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Presensi Baru
        </a>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Kegiatan</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Jam</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($presensiList as $presensi)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3"><span class="font-medium text-gray-800">{{ $presensi->hari }}, {{ $presensi->tanggal->format('d M Y') }}</span></td>
                        <td class="px-4 py-3 text-gray-600">{{ $presensi->kegiatanPondok->nama_kegiatan }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $presensi->jam_mulai }}{{ $presensi->jam_selesai ? ' - ' . $presensi->jam_selesai : '' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $presensi->status === 'valid' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($presensi->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('ustadz.presensi-kegiatan.show', $presensi) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada riwayat presensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $presensiList->links() }}</div>
</div>
@endsection
