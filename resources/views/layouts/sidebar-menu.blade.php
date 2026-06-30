{{-- Sidebar navigation menu - dynamically shows items based on user role --}}

@php
    $currentRoute = request()->route()?->getName() ?? '';
@endphp

{{-- ===== ADMIN MENU ===== --}}
@role('admin')
    <p class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-emerald-400">Menu Admin</p>

    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.dashboard') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Dashboard
    </a>

    <a href="{{ route('admin.kegiatan.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.kegiatan') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        Kegiatan Pondok
    </a>

    <a href="{{ route('admin.santri.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.santri') && !str_starts_with($currentRoute, 'admin.santri-binaan') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        Data Santri
    </a>

    <a href="{{ route('admin.ustadz.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.ustadz') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        Data Ustadz
    </a>

    <a href="{{ route('admin.wali-murid.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.wali-murid') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        Data Wali Murid
    </a>

    <p class="px-3 mt-6 mb-2 text-xs font-semibold uppercase tracking-wider text-emerald-400">Penugasan</p>

    <a href="{{ route('admin.penugasan-kegiatan.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.penugasan-kegiatan') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        Ustadz → Kegiatan
    </a>

    <a href="{{ route('admin.santri-binaan.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.santri-binaan') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
        Santri Binaan
    </a>

    <p class="px-3 mt-6 mb-2 text-xs font-semibold uppercase tracking-wider text-emerald-400">Laporan</p>

    <a href="{{ route('admin.laporan.presensi-ustadz') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.laporan.presensi-ustadz') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Presensi Ustadz
    </a>

    <a href="{{ route('admin.laporan.presensi-santri') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.laporan.presensi-santri') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Presensi Santri
    </a>

    <a href="{{ route('admin.laporan.hafalan') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.laporan.hafalan') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        Setoran Hafalan
    </a>

    <a href="{{ route('admin.laporan.murojaah') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'admin.laporan.murojaah') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        Murojaah
    </a>
@endrole

{{-- ===== USTADZ MENU ===== --}}
@role('ustadz')
    <p class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-emerald-400">Menu Ustadz</p>

    <a href="{{ route('ustadz.dashboard') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'ustadz.dashboard') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Dashboard
    </a>

    <p class="px-3 mt-6 mb-2 text-xs font-semibold uppercase tracking-wider text-emerald-400">Presensi</p>

    <a href="{{ route('ustadz.presensi-kegiatan.create') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ $currentRoute === 'ustadz.presensi-kegiatan.create' ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Presensi Kegiatan
    </a>

    <a href="{{ route('ustadz.presensi-kegiatan.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ $currentRoute === 'ustadz.presensi-kegiatan.index' ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Riwayat Presensi
    </a>

    <p class="px-3 mt-6 mb-2 text-xs font-semibold uppercase tracking-wider text-emerald-400">Hafalan & Murojaah</p>

    <a href="{{ route('ustadz.setoran-hafalan.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'ustadz.setoran-hafalan') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        Setoran Hafalan
    </a>

    <a href="{{ route('ustadz.murojaah.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'ustadz.murojaah') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        Murojaah
    </a>
@endrole

{{-- ===== WALI MURID MENU ===== --}}
@role('wali_murid')
    <p class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-emerald-400">Menu Wali Murid</p>

    <a href="{{ route('wali-murid.dashboard') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'wali-murid.dashboard') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Dashboard
    </a>

    <a href="{{ route('wali-murid.laporan-mingguan.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'wali-murid.laporan-mingguan') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Laporan Mingguan
    </a>

    <a href="{{ route('wali-murid.riwayat-kegiatan.index') }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ str_starts_with($currentRoute, 'wali-murid.riwayat-kegiatan') ? 'bg-white/15 text-white' : 'text-emerald-100 hover:bg-white/10' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Riwayat Kegiatan
    </a>
@endrole
