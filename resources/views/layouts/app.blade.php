<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Sistem Manajemen Pondok Pesantren Tahfidzil Quran Muhammadiyah Ibnu Juraimi">

        <title>{{ config('app.name', 'PPTQ Ibnu Juraimi') }} — @yield('title', 'Dashboard')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

            <!-- Mobile sidebar overlay -->
            <div x-show="sidebarOpen" x-cloak
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden"
                 @click="sidebarOpen = false">
            </div>

            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-emerald-800 to-emerald-950 text-white shadow-xl transform transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col">

                <!-- Logo -->
                <div class="flex items-center gap-3 px-6 py-5 border-b border-emerald-700/50">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-white/10 backdrop-blur-sm">
                        <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-sm font-bold leading-tight">PPTQ</h1>
                        <p class="text-xs text-emerald-300">Ibnu Juraimi</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                    @include('layouts.sidebar-menu')
                </nav>

                <!-- User Info -->
                <div class="p-4 border-t border-emerald-700/50">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-600 text-sm font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-emerald-300 truncate capitalize">{{ Auth::user()->roles->first()?->name ?? 'User' }}</p>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-h-screen w-full lg:pl-64">
                <!-- Top Navbar -->
                <header class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
                    <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8 w-full">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <h2 class="text-lg font-semibold text-gray-800">
                            @yield('page-title', 'Dashboard')
                        </h2>

                        <!-- Right side -->
                        <div class="flex items-center gap-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="hidden sm:inline">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="mx-4 sm:mx-6 mt-4">
                        <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mx-4 sm:mx-6 mt-4">
                        <div class="px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-red-800">
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                <main class="flex-1 max-w-7xl w-full mx-auto p-4 sm:p-6 lg:p-8">
                    {{ $slot ?? '' }}
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
