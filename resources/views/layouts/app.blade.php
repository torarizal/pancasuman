<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- 1. Meta Title & Description dari Database / View --}}
    <title>@yield('title', 'Pancasuman - Portal Komunitas & Literasi')</title>
    <meta name="description" content="{{ $metaDescription ?? 'Portal resmi komunitas Pancasuman. Menghimpun karya literasi, kegiatan, dan informasi terkini dari jamaah Maiyah.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'Pancasuman, Maiyah, Cak Nun, Emha Ainun Nadjib, Jamaah Maiyah, Komunitas Literasi' }}">
    
    {{-- 2. Open Graph / Social Media (ambil dari database jika ada) --}}
    <meta property="og:title" content="@yield('title', 'Pancasuman')">
    <meta property="og:description" content="{{ $metaDescription ?? 'Portal resmi komunitas Pancasuman.' }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    @hasSection('og_image')
    <meta property="og:image" content="@yield('og_image')">
    @endif
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Pancasuman')">
    <meta name="twitter:description" content="{{ $metaDescription ?? 'Portal resmi komunitas Pancasuman.' }}">
    @hasSection('og_image')
    <meta name="twitter:image" content="@yield('og_image')">
    @endif

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50/70 text-slate-800 font-sans antialiased flex flex-col min-h-screen selection:bg-blue-600 selection:text-white relative">

    {{-- Ambient Decorative Glows --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-100/60 rounded-full blur-3xl opacity-70"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-indigo-100/50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-40 left-1/4 w-96 h-96 bg-amber-100/40 rounded-full blur-3xl opacity-50"></div>
    </div>

    {{-- Navbar Publik --}}
    <nav class="glass-nav border-b border-slate-200/80 sticky top-0 z-50 transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-18 flex justify-between items-center gap-4">
                
                {{-- Brand Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-blue-500 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 group-hover:shadow-blue-500/30 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-slate-900 via-blue-950 to-blue-700 bg-clip-text text-transparent">
                            PANCASUMAN
                        </span>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-slate-400 -mt-1">
                            Portal Literasi
                        </span>
                    </div>
                </a>

                {{-- Desktop Navigation Links --}}
                <div class="hidden lg:flex items-center space-x-1 text-sm font-medium">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-100/80' }}">
                        Beranda
                    </a>
                    <a href="{{ route('archive') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('archive') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-100/80' }}">
                        Eksplor
                    </a>
                    <a href="{{ route('articles') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('articles') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-100/80' }}">
                        Artikel
                    </a>
                    <a href="{{ route('series.index') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('series.*') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-100/80' }}">
                        Series
                    </a>
                    <a href="{{ route('authors.index') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('authors.*') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-100/80' }}">
                        Penulis
                    </a>
                    <a href="{{ route('biografi.caknun') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('biografi.caknun') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-100/80' }}">
                        Biografi Cak Nun
                    </a>
                    <a href="{{ route('about') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-100/80' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('contact') }}" class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('contact') ? 'bg-blue-50 text-blue-700 font-semibold shadow-xs' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-100/80' }}">
                        Kontak
                    </a>
                </div>

                {{-- Action Button (Desktop) & Hamburger Toggle (Mobile) --}}
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50/80 hover:bg-blue-100/80 px-4 py-2.5 rounded-xl border border-blue-200/60 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Masuk</span>
                        </a>
                    @endauth

                    {{-- Mobile Menu Hamburger Button --}}
                    <button id="mobile-menu-button" type="button" class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition focus:outline-hidden" aria-label="Menu" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu Drawer --}}
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200/80 bg-white/95 backdrop-blur-md px-4 pt-3 pb-5 space-y-1.5 shadow-lg">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                Beranda
            </a>
            <a href="{{ route('archive') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('archive') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                Eksplor Arsip
            </a>
            <a href="{{ route('articles') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('articles') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                Artikel
            </a>
            <a href="{{ route('series.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('series.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                Master Series
            </a>
            <a href="{{ route('authors.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('authors.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                Penulis
            </a>
            <a href="{{ route('biografi.caknun') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('biografi.caknun') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                Biografi Cak Nun
            </a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                Tentang Kami
            </a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('contact') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                Kontak
            </a>
            
            <div class="pt-3 border-t border-slate-100">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-xs">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 text-blue-600 bg-blue-50 text-sm font-semibold px-4 py-2.5 rounded-xl">
                        Masuk ke Akun
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 w-full">
        @yield('content')
    </main>

    {{-- Floating Back To Top Button --}}
    <button id="back-to-top" type="button" aria-label="Kembali ke atas" class="fixed bottom-6 right-6 z-40 p-3 rounded-full bg-white/90 text-slate-700 shadow-lg border border-slate-200/80 backdrop-blur-md opacity-0 pointer-events-none translate-y-4 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    {{-- Footer Modern & Hangat --}}
    <footer class="bg-white/80 border-t border-slate-200/80 backdrop-blur-sm mt-16 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">
                
                {{-- Col 1: Brand & Filosofi --}}
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-900">
                            PANCASUMAN
                        </span>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed max-w-md">
                        Ruang literasi bersama, memuat esai pemikiran, refleksi budaya, dan cerpen bersambung yang dijiwai semangat keteduhan jamaah Maiyah dan keterbukaan silaturahmi.
                    </p>
                    <div class="pt-2 text-xs text-slate-500 flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Terbuka untuk tulisan & karya kontributor</span>
                    </div>
                </div>

                {{-- Col 2: Jelajahi --}}
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Jelajahi Portal</h4>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
                        </li>
                        <li>
                            <a href="{{ route('archive') }}" class="hover:text-blue-600 transition-colors">Eksplor Arsip</a>
                        </li>
                        <li>
                            <a href="{{ route('articles') }}" class="hover:text-blue-600 transition-colors">Kumpulan Artikel</a>
                        </li>
                        <li>
                            <a href="{{ route('series.index') }}" class="hover:text-blue-600 transition-colors">Master Series</a>
                        </li>
                        <li>
                            <a href="{{ route('authors.index') }}" class="hover:text-blue-600 transition-colors">Direktori Penulis</a>
                        </li>
                    </ul>
                </div>

                {{-- Col 3: Informasi & Tokoh --}}
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Informasi</h4>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li>
                            <a href="{{ route('biografi.caknun') }}" class="hover:text-blue-600 transition-colors">Biografi Cak Nun</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="hover:text-blue-600 transition-colors">Tentang Pancasuman</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="hover:text-blue-600 transition-colors">Kontak & Redaksi</a>
                        </li>
                        @auth
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 font-medium hover:underline">Panel Admin</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="text-slate-500 hover:text-blue-600 transition-colors">Masuk Pengelola</a>
                            </li>
                        @endauth
                    </ul>
                </div>

            </div>

            {{-- Bottom Border & Copyright --}}
            <div class="mt-12 pt-8 border-t border-slate-200/70 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Pancasuman Community Portal. Hak Cipta Dilindungi.</p>
                <p class="text-slate-400">Dirajut dengan takzim demi kebaikan literasi & kebersamaan.</p>
            </div>
        </div>
    </footer>

</body>
</html>