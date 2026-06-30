@extends('layouts.app')
@section('title', 'Data Wali Murid')
@section('page-title', 'Data Wali Murid')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">Kelola akun wali murid.</p>
        <a href="{{ route('admin.wali-murid.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Wali Murid
        </a>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Email</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Jumlah Anak</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($waliMuridList as $index => $wali)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-500">{{ $waliMuridList->firstItem() + $index }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">
                            <a href="{{ route('admin.wali-murid.show', $wali) }}" class="hover:text-emerald-600 hover:underline">{{ $wali->name }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $wali->email }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($wali->santri_as_wali_count > 0)
                                <div class="flex flex-col gap-1 items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700 mb-1">{{ $wali->santri_as_wali_count }} Anak</span>
                                    @foreach($wali->santriAsWali as $anak)
                                        <span class="text-xs text-gray-500">{{ $anak->nama }} ({{ $anak->tingkatan_label }})</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">0 Anak</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.wali-murid.edit', $wali) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                <form action="{{ route('admin.wali-murid.destroy', $wali) }}" method="POST" onsubmit="return confirm('Yakin hapus wali murid ini?')">@csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada data wali murid.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $waliMuridList->links() }}</div>
</div>
@endsection
