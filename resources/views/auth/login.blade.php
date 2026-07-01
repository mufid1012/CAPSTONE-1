<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'PPTQ Ibnu Juraimi') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>
<body class="antialiased text-gray-900 bg-gray-50 flex h-screen overflow-hidden">

    <!-- Left Panel (Brand/Visual) -->
    <div class="hidden lg:flex lg:w-1/2 bg-emerald-900 relative items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-pattern"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/90 to-emerald-800/80"></div>
        
        <div class="relative z-10 w-full max-w-lg px-12 flex flex-col items-start">

            <h1 class="text-4xl font-bold text-white mb-4 leading-tight">Sistem Informasi<br>Administrasi Pesantren</h1>
            <p class="text-emerald-100 text-lg leading-relaxed mb-12">Platform terpadu untuk mengelola kegiatan PPTQ Ibnu Juraimi menjadi lebih efisien, transparan, dan terpantau dengan baik.</p>
            

        </div>

        <!-- Decorative blur blobs -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-500/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-400/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-20 w-96 h-96 bg-emerald-600/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Right Panel (Form) -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center relative bg-white">
        <!-- Mobile Logo -->
        <div class="lg:hidden absolute top-8 left-8 flex items-center gap-3">
            <span class="font-bold text-gray-800 text-xl tracking-tight">PPTQ</span>
        </div>

        <div class="w-full max-w-md mx-auto px-8 py-10">
            <div class="mb-10 text-center lg:text-left">
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Selamat Datang</h2>
                <p class="text-gray-500 mt-2 text-sm">Silakan masuk menggunakan akun yang telah didaftarkan.</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                            class="block w-full pl-10 pr-3 py-3 border @error('email') border-red-300 ring-1 ring-red-300 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors bg-gray-50/50 hover:bg-gray-50 placeholder-gray-400" 
                            placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-500 transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" 
                            class="block w-full pl-10 pr-3 py-3 border @error('password') border-red-300 ring-1 ring-red-300 @else border-gray-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors bg-gray-50/50 hover:bg-gray-50 placeholder-gray-400" 
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer transition">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">
                        Ingat sesi login
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all active:scale-[0.98]">
                    Masuk ke Sistem
                </button>
            </form>

            <!-- Akun Demo Info (Opsional, sangat membantu saat presentasi) -->
            <div class="mt-8 p-4 rounded-xl bg-blue-50 border border-blue-100 hidden">
                <h4 class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-2">Akses Demo</h4>
                <div class="text-xs text-blue-700 space-y-1">
                    <p>Admin: admin@pptq.test</p>
                    <p>Ustadz: ustadz1@pptq.test</p>
                    <p>Wali: wali1@pptq.test</p>
                    <p class="font-medium mt-2 pt-2 border-t border-blue-200">Password: password</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-center">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} PPTQ Ibnu Juraimi. Hak cipta dilindungi.
                </p>
            </div>
        </div>
    </div>

</body>
</html>
