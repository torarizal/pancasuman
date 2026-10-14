<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Developer Console - Pancasuman')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 font-sans antialiased flex h-screen overflow-hidden">

    {{-- Sidebar Khusus Developer --}}
    <aside class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col shrink-0 z-30 shadow-xl hidden md:flex">
        {{-- Brand / Header Sidebar --}}
        <div class="h-18 px-6 border-b border-slate-800/80 flex items-center justify-between">
            <a href="{{ route('admin.developer.dashboard') }}" class="flex items-center gap-2.5 group">
                @if(!empty($siteLogo))
                    <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo" class="max-h-9 max-w-[140px] object-contain">
                @else
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-white shadow-sm shadow-purple-500/20 group-hover:scale-105 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm font-black tracking-tight text-white block leading-tight">PANCASUMAN</span>
                        <span class="text-[10px] font-mono uppercase tracking-widest text-purple-400 block -mt-0.5">DEV CONSOLE</span>
                    </div>
                @endif
            </a>
        </div>

        {{-- Profil Developer (Klik untuk Ubah Profil) --}}
        <a href="{{ route('admin.profile.edit') }}" title="Klik untuk ubah profil & kata sandi" class="p-4 mx-3 my-3 rounded-2xl bg-slate-900 hover:bg-slate-800/80 border border-slate-800 hover:border-purple-700/60 transition flex items-center gap-3 group">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-full object-cover shrink-0 border border-purple-500/50">
            @else
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-bold flex items-center justify-center text-xs shadow-xs shrink-0">
                    {{ substr(auth()->user()->name ?? 'D', 0, 1) }}
                </div>
            @endif
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-white group-hover:text-purple-300 transition truncate">{{ auth()->user()->name }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] font-mono uppercase tracking-wider text-purple-300">Developer</span>
                    <span class="text-[9px] text-purple-400 font-mono ml-auto opacity-0 group-hover:opacity-100 transition-opacity">Edit &rarr;</span>
                </div>
            </div>
        </a>

        {{-- Menu Navigasi Developer --}}
        <nav class="flex-1 px-3 py-2 space-y-1 overflow-y-auto text-sm">
            <div class="px-3 pb-1.5 text-[10px] font-mono uppercase tracking-widest text-slate-500">System Monitoring</div>
            
            {{-- System Dashboard --}}
            <a href="{{ route('admin.developer.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.developer.dashboard') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.developer.dashboard') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>System Dashboard</span>
            </a>

            {{-- Manajemen Akun Pengguna & Hak Akses --}}
            <a href="{{ route('admin.developer.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.developer.users.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.developer.users.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Manajemen User</span>
            </a>

            {{-- Pengaturan Logo & Branding Web --}}
            <a href="{{ route('admin.developer.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.developer.settings.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.developer.settings.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Logo & Branding Web</span>
            </a>

            {{-- Master Halaman Statis --}}
            <a href="{{ route('admin.developer.pages.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.developer.pages.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.developer.pages.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <span>Halaman Statis</span>
            </a>

            <div class="pt-4 px-3 pb-1.5 text-[10px] font-mono uppercase tracking-widest text-slate-500">Struktur Master</div>

            {{-- Master Kategori --}}
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span>Master Kategori</span>
            </a>

            {{-- Master Series --}}
            <a href="{{ route('admin.series.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.series.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.series.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Master Series</span>
            </a>

            {{-- Manajemen Konten --}}
            <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>Semua Artikel</span>
            </a>

            <div class="pt-4 px-3 pb-1.5 text-[10px] font-mono uppercase tracking-widest text-slate-500">Peralihan & Akses</div>
            
            {{-- Profil Akun --}}
            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-900 hover:text-purple-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Ubah Profil Saya</span>
            </a>

            {{-- Ke Admin Biasa --}}
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-900 hover:text-blue-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                </svg>
                <span>Panel Admin Konten</span>
            </a>

            {{-- Website Publik --}}
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-900 hover:text-white transition-colors">
                <span class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Kunjungi Website</span>
                </span>
                <span class="text-[10px] text-slate-500">&nearr;</span>
            </a>
        </nav>

        {{-- Tombol Logout --}}
        <div class="p-3 border-t border-slate-800/80">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 border border-transparent hover:border-rose-500/30 transition-all cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile Developer Drawer & Backdrop --}}
    <div id="dev-sidebar-backdrop" class="fixed inset-0 bg-slate-950/80 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>
    <aside id="dev-mobile-drawer" class="fixed inset-y-0 left-0 w-72 bg-slate-950 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden flex flex-col shadow-2xl border-r border-slate-800 text-slate-100">
        <div class="h-18 px-6 border-b border-slate-800 flex items-center justify-between">
            <a href="{{ route('admin.developer.dashboard') }}" class="flex items-center gap-2.5">
                @if(!empty($siteLogo))
                    <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo" class="max-h-8 max-w-[130px] object-contain">
                @else
                    <div class="w-8 h-8 rounded-xl bg-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                        DEV
                    </div>
                    <div>
                        <span class="text-sm font-black tracking-tight text-white block leading-tight">PANCASUMAN</span>
                        <span class="text-[9px] font-mono uppercase tracking-widest text-purple-400 block -mt-0.5">DEV CONSOLE</span>
                    </div>
                @endif
            </a>
            <button id="dev-sidebar-close" type="button" class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition cursor-pointer" aria-label="Tutup Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Profil Developer Mobile --}}
        <a href="{{ route('admin.profile.edit') }}" title="Klik untuk ubah profil" class="p-3 mx-3 my-3 rounded-xl bg-slate-900 border border-slate-800 hover:border-purple-600/60 transition flex items-center gap-3">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover shrink-0 border border-purple-500/50">
            @else
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-bold flex items-center justify-center text-xs shadow-xs shrink-0">
                    {{ substr(auth()->user()->name ?? 'D', 0, 1) }}
                </div>
            @endif
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[9px] font-mono uppercase tracking-wider text-purple-300">Super Developer</span>
                </div>
            </div>
            <span class="text-[10px] text-purple-400 font-mono">&rarr;</span>
        </a>

        <nav class="flex-1 px-3 py-2 space-y-1 overflow-y-auto text-sm">
            <div class="px-3 pb-1 text-[10px] font-mono uppercase tracking-widest text-slate-500">System Monitoring</div>
            <a href="{{ route('admin.developer.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.developer.dashboard') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.developer.dashboard') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>System Dashboard</span>
            </a>
            <a href="{{ route('admin.developer.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.developer.users.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.developer.users.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Manajemen User</span>
            </a>
            <a href="{{ route('admin.developer.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.developer.settings.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.developer.settings.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Logo & Branding Web</span>
            </a>
            <a href="{{ route('admin.developer.pages.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.developer.pages.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.developer.pages.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <span>Halaman Statis</span>
            </a>

            <div class="pt-3 px-3 pb-1 text-[10px] font-mono uppercase tracking-widest text-slate-500">Struktur Master</div>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span>Master Kategori</span>
            </a>
            <a href="{{ route('admin.series.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.series.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.series.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Master Series</span>
            </a>
            <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-purple-600 text-white font-semibold shadow-xs' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ request()->routeIs('admin.posts.*') ? 'text-white' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>Semua Artikel</span>
            </a>

            <div class="pt-3 px-3 pb-1 text-[10px] font-mono uppercase tracking-widest text-slate-500">Peralihan & Akses</div>
            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-900 hover:text-purple-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Ubah Profil Saya</span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-900 hover:text-blue-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                </svg>
                <span>Panel Admin Konten</span>
            </a>
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-900 hover:text-white">
                <span class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Kunjungi Website</span>
                </span>
                <span class="text-[10px] text-slate-500">&nearr;</span>
            </a>
        </nav>

        <div class="p-3 border-t border-slate-800">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-rose-400 hover:bg-rose-500/10 border border-rose-500/30 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Wrapper --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-900">
        {{-- Topbar --}}
        <header class="h-18 bg-slate-950/80 border-b border-slate-800/90 px-4 sm:px-8 flex items-center justify-between shrink-0 shadow-sm backdrop-blur-md">
            <div class="flex items-center gap-3">
                <div class="md:hidden">
                    <button id="dev-sidebar-toggle" type="button" class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition cursor-pointer" aria-label="Buka Menu Developer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                <div>
                    <h1 class="text-base sm:text-xl font-black text-white tracking-tight flex items-center gap-2 truncate max-w-[190px] sm:max-w-none">
                        <span>@yield('header', 'System Overview')</span>
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-purple-300 border border-purple-500/30 text-xs font-semibold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8" />
                    </svg>
                    <span>Ke Admin Konten</span>
                </a>

                <a href="{{ route('home') }}" target="_blank" class="px-3 py-1.5 rounded-lg border border-slate-700 text-slate-300 hover:text-white hover:border-slate-500 text-xs font-semibold transition hidden sm:inline-flex items-center gap-1">
                    <span>Lihat Web</span>
                    <span class="text-[10px]">&nearr;</span>
                </a>

                {{-- Mobile Logout --}}
                <form action="{{ route('admin.logout') }}" method="POST" class="md:hidden inline">
                    @csrf
                    <button type="submit" title="Logout" class="p-2 text-slate-400 hover:text-rose-400 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </header>

        {{-- Content Area --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-900/90 p-4 sm:p-8">
            <div class="max-w-7xl mx-auto space-y-6">
                {{-- Flash Message Success --}}
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-950/80 border border-emerald-800 text-emerald-200 text-sm font-medium flex items-center justify-between shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                {{-- Flash Message Error --}}
                @if(session('error'))
                    <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-800 text-rose-200 text-sm font-medium flex items-center justify-between shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rose-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
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