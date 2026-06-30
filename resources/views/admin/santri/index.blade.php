@extends('layouts.app')
@section('title', 'Data Santri')
@section('page-title', 'Data Santri')

@section('content')
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <p class="text-sm text-gray-500">Kelola data santri pondok pesantren.</p>
        <a href="{{ route('admin.santri.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Santri
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.santri.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS..."
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <div class="w-full sm:w-48">
                <select name="tingkatan" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    <option value="">Semua Tingkatan</option>
                    @foreach(\App\Models\Santri::TINGKATAN_LABELS as $key => $label)
                        <option value="{{ $key }}" {{ request('tingkatan') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-36">
                <select name="kelas" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}" {{ request('kelas') === $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">Filter</button>
                @if(request()->hasAny(['search', 'tingkatan', 'kelas']))
                    <a href="{{ route('admin.santri.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">NIS</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Tingkatan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Kelas</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Wali Murid</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($santriList as $index => $santri)
                        @php
                            $badgeColors = ['tsanawiyah' => 'bg-blue-100 text-blue-700', 'aliyah' => 'bg-purple-100 text-purple-700', 'takhassus' => 'bg-amber-100 text-amber-700'];
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $santriList->firstItem() + $index }}</td>
                            <td class="px-4 py-3 font-mono text-gray-600">{{ $santri->nis }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $santri->nama }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColors[$santri->tingkatan] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $santri->tingkatan_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $santri->kelas ?: '-' }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $santri->waliMurid?->name ?: '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.santri.edit', $santri) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.santri.destroy', $santri) }}" method="POST" onsubmit="return confirm('Yakin hapus data santri ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada data santri.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $santriList->links() }}</div>
</div>
@endsection
