@extends('layouts.app')
@section('title', 'Kegiatan Pondok')
@section('page-title', 'Kegiatan Pondok')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <p class="text-sm text-gray-500">Daftar kegiatan rutin pondok pesantren.</p>
        <a href="{{ route('admin.kegiatan.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Kegiatan
        </a>
    </div>

    <!-- Filter Tingkatan -->
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.kegiatan.index') }}" class="px-3 py-1.5 text-sm font-medium rounded-full border transition {{ !request('tingkatan') ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-gray-600 border-gray-300 hover:border-emerald-300' }}">Semua</a>
        @foreach(\App\Models\KegiatanPondok::TINGKATAN_OPTIONS as $key => $label)
            <a href="{{ route('admin.kegiatan.index', ['tingkatan' => $key]) }}" class="px-3 py-1.5 text-sm font-medium rounded-full border transition {{ request('tingkatan') === $key ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-gray-600 border-gray-300 hover:border-emerald-300' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama Kegiatan</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Tingkatan</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Deskripsi</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Ustadz</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kegiatan as $index => $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-500">{{ $kegiatan->firstItem() + $index }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">
                            <a href="{{ route('admin.kegiatan.show', $item) }}" class="hover:text-emerald-600 hover:underline">{{ $item->nama_kegiatan }}</a>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $badgeColors = ['semua' => 'bg-gray-100 text-gray-700', 'tsanawiyah' => 'bg-blue-100 text-blue-700', 'aliyah' => 'bg-purple-100 text-purple-700', 'takhassus' => 'bg-amber-100 text-amber-700'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColors[$item->tingkatan] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $item->tingkatan_label }}
                            </span>
                            @if($item->kelas)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 ml-1">Kelas {{ $item->kelas }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ Str::limit($item->deskripsi, 40) ?: '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">{{ $item->ustadz_count }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.kegiatan.show', $item) }}" class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.kegiatan.edit', $item) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.kegiatan.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus kegiatan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada data kegiatan pondok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $kegiatan->links() }}</div>
</div>
@endsection
