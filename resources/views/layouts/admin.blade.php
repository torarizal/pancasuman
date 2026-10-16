<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Pancasuman')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

    {{-- Anti-FOUC Dark Mode Initialization --}}
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-800 dark:text-slate-100 font-sans antialiased flex h-screen overflow-hidden transition-colors duration-200">

    {{-- Sidebar Admin --}}
    <aside class="w-64 bg-white border-r border-slate-200/90 flex flex-col shrink-0 z-30 shadow-xs hidden md:flex">
        {{-- Brand / Header Sidebar --}}
        {{-- Brand / Logo --}}
        <div class="h-18 px-6 border-b border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
                @if(!empty($siteLogo))
                    <div class="w-9 h-9 rounded-xl overflow-hidden flex items-center justify-center bg-white shadow-xs border border-slate-200/80 group-hover:scale-105 transition-transform shrink-0">
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo" class="w-full h-full object-contain p-0.5">
                    </div>
                @else
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-blue-500 flex items-center justify-center text-white shadow-sm shadow-blue-500/20 group-hover:scale-105 transition-transform shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                @endif
                <div>
                    <span class="text-base font-black tracking-tight text-slate-900 block leading-tight">PANCASUMAN</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block -mt-0.5">Admin Workspace</span>
                </div>
            </a>
        </div>

        {{-- Profil Singkat di Sidebar (Klik untuk Ubah Profil) --}}
        <a href="{{ route('admin.profile.edit') }}" title="Klik untuk ubah profil & kata sandi" class="p-3 mx-3 my-3 rounded-2xl bg-slate-50 hover:bg-blue-50/70 border border-slate-100 hover:border-blue-200 transition-all flex items-center gap-3 group">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover shrink-0 border border-slate-200 group-hover:border-blue-400 transition">
            @else
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-xs shadow-xs shrink-0">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
            @endif
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-900 group-hover:text-blue-700 transition truncate">{{ auth()->user()->name }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full {{ auth()->user()->isDeveloper() ? 'bg-purple-600' : 'bg-emerald-500' }}"></span>
                    <span class="text-[10px] uppercase font-semibold {{ auth()->user()->isDeveloper() ? 'text-purple-700' : 'text-slate-500' }}">
                        {{ auth()->user()->role ?? 'Admin' }}
                    </span>
                    <span class="text-[9px] text-blue-600 font-medium ml-auto opacity-0 group-hover:opacity-100 transition-opacity">Edit &rarr;</span>
                </div>
            </div>
        </a>

        {{-- Menu Navigasi Utama --}}
        <nav class="flex-1 px-3 py-2 space-y-1 overflow-y-auto text-sm">
            <div class="px-3 pb-1.5 text-[11px] font-bold uppercase tracking-wider text-slate-400">Navigasi Utama</div>
            
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- Artikel & Konten --}}
            <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>Manajemen Artikel</span>
            </a>

            {{-- Master Series --}}
            <a href="{{ route('admin.series.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.series.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.series.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Master Series</span>
            </a>

            {{-- Kategori (Rubrik) --}}
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span>Manajemen Kategori</span>
            </a>

            {{-- Galeri Foto Kegiatan --}}
            <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.galleries.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.galleries.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Galeri Foto</span>
            </a>

            {{-- Video Dokumentasi --}}
            <a href="{{ route('admin.videos.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.videos.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.videos.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span>Video Dokumentasi</span>
            </a>

            {{-- Pengaturan Profil Akun --}}
            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.profile.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Profil Saya</span>
            </a>

            {{-- Khusus Developer --}}
            @if(auth()->user()->isDeveloper())
                <div class="pt-4 px-3 pb-1.5 text-[11px] font-bold uppercase tracking-wider text-purple-600">Hak Akses Developer</div>
                <a href="{{ route('admin.developer.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors text-purple-700 bg-purple-50/70 hover:bg-purple-100/80 border border-purple-200/60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    <span>Developer Console</span>
                </a>
            @endif

            <div class="pt-4 px-3 pb-1.5 text-[11px] font-bold uppercase tracking-wider text-slate-400">Portal Publik</div>
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100/80 hover:text-slate-900 transition-colors">
                <span class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Kunjungi Website</span>
                </span>
                <span class="text-[10px] text-slate-400">&nearr;</span>
            </a>
        </nav>

        {{-- Tombol Logout di Bawah Sidebar --}}
        <div class="p-3 border-t border-slate-100">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-red-600 hover:bg-red-50 hover:text-red-700 border border-transparent hover:border-red-200 transition-all cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile Sidebar Drawer & Backdrop --}}
    <div id="admin-sidebar-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>
    <aside id="admin-mobile-drawer" class="fixed inset-y-0 left-0 w-72 bg-white z-50 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden flex flex-col shadow-2xl border-r border-slate-200">
        <div class="h-18 px-6 border-b border-slate-100 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                @if(!empty($siteLogo))
                    <div class="w-8 h-8 rounded-lg overflow-hidden flex items-center justify-center bg-white shadow-xs border border-slate-200/80 shrink-0">
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo" class="w-full h-full object-contain p-0.5">
                    </div>
                @else
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-xs shrink-0">P</div>
                @endif
                <div>
                    <span class="text-sm font-black tracking-tight text-slate-900 block leading-tight">PANCASUMAN</span>
                    <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 block -mt-0.5">Admin Workspace</span>
                </div>
            </a>
            <button id="admin-sidebar-close" type="button" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition cursor-pointer" aria-label="Tutup Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <a href="{{ route('admin.profile.edit') }}" class="p-3 mx-3 my-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-200 transition flex items-center gap-3">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover shrink-0">
            @else
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-xs shadow-xs shrink-0">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
            @endif
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full {{ auth()->user()->isDeveloper() ? 'bg-purple-600' : 'bg-emerald-500' }}"></span>
                    <span class="text-[9px] uppercase font-semibold text-slate-500">
                        {{ auth()->user()->role ?? 'Admin' }}
                    </span>
                    <span class="text-[9px] text-blue-600 ml-auto font-medium">Edit &rarr;</span>
                </div>
            </div>
        </a>

        <nav class="flex-1 px-3 py-2 space-y-1 overflow-y-auto text-sm">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>Manajemen Artikel</span>
            </a>
            <a href="{{ route('admin.series.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.series.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.series.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Master Series</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span>Manajemen Kategori</span>
            </a>
            <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.galleries.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.galleries.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Galeri Foto</span>
            </a>
            <a href="{{ route('admin.videos.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.videos.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.videos.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span>Video Dokumentasi</span>
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-blue-600 text-white shadow-xs font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.profile.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Profil Saya</span>
            </a>
            @if(auth()->user()->isDeveloper())
                <div class="pt-2 px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-purple-600">Hak Akses Developer</div>
                <a href="{{ route('admin.developer.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-purple-700 bg-purple-50/70 border border-purple-200/60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    <span>Developer Console</span>
                </a>
            @endif
            <div class="pt-2 px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">Portal Publik</div>
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100">
                <span class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Kunjungi Website</span>
                </span>
                <span class="text-[10px] text-slate-400">&nearr;</span>
            </a>
        </nav>

        <div class="p-3 border-t border-slate-100">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-red-600 hover:bg-red-50 border border-red-200 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Wrapper --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        {{-- Topbar --}}
        <header class="h-18 bg-white border-b border-slate-200/90 px-4 sm:px-8 flex items-center justify-between shrink-0 shadow-2xs">
            <div class="flex items-center gap-3">
                {{-- Tombol Navigasi Mobile (Garis Tiga) --}}
                <div class="md:hidden">
                    <button id="admin-sidebar-toggle" type="button" class="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition cursor-pointer" aria-label="Buka Menu Navigasi">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div>
                    <h1 class="text-base sm:text-xl font-black text-slate-900 tracking-tight truncate max-w-[190px] sm:max-w-none">@yield('header', 'Dashboard')</h1>
                </div>
            </div>

            <div class="flex items-center gap-2.5 sm:gap-4">
                {{-- Quick Action: Tulis Artikel Baru --}}
                <a href="{{ route('admin.posts.create') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tulis Artikel</span>
                </a>

                @if(auth()->user()->isDeveloper())
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-200 text-[11px] font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-600"></span>
                        <span>Dev Mode</span>
                    </span>
                @endif

                {{-- Link Website Cepat --}}
                <a href="{{ route('home') }}" target="_blank" class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 hover:border-blue-300 dark:hover:border-blue-700 text-xs font-semibold transition hidden sm:inline-flex items-center gap-1">
                    <span>Lihat Web</span>
                    <span class="text-[10px]">&nearr;</span>
                </a>

                {{-- Tombol Switch Dark Mode (Admin Topbar) --}}
                <button id="admin-theme-toggle" type="button" class="relative inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-amber-400 shadow-2xs hover:shadow-xs transition cursor-pointer group focus:outline-hidden" aria-label="Alihkan tema" title="Beralih Tema (Dark/Light)">
                    <svg id="admin-theme-sun" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden dark:block text-amber-400 group-hover:rotate-45 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg id="admin-theme-moon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 block dark:hidden text-slate-600 group-hover:text-blue-600 group-hover:-rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                {{-- Logout Button Mobile --}}
                <form action="{{ route('admin.logout') }}" method="POST" class="md:hidden inline">
                    @csrf
                    <button type="submit" title="Logout" class="p-2 text-slate-400 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </header>

        {{-- Content Area --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50/80 dark:bg-slate-950 p-4 sm:p-8">
            <div class="max-w-7xl mx-auto space-y-6">
                {{-- Flash Message Success --}}
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center justify-between shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                {{-- Flash Message Error --}}
                @if(session('error'))
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium flex items-center justify-between shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rose-600 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    {{-- Service Worker untuk Caching Media & Gambar --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js', { scope: '/' })
                    .catch(() => {});
            });
        }
    </script>
</body>
</html>