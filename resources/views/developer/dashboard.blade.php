@extends('layouts.developer')

@section('title', 'System Dashboard - Developer Console')
@section('header', 'System Monitoring & Overview')

@section('content')
<div class="space-y-8">
    
    {{-- Banner Status Developer --}}
    <div class="bg-gradient-to-r from-purple-950 via-slate-900 to-indigo-950 border border-purple-800/40 rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-900/60 border border-purple-700/60 text-xs font-mono text-purple-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>ENVIRONMENT: {{ strtoupper(app()->environment()) }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black font-mono tracking-tight text-white">
                    Pancasuman Developer Console
                </h2>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                    Pusat pemantauan status arsitektur, parameter server, status penyimpanan berkas, dan konfigurasi master halaman statis.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('admin.developer.pages.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs sm:text-sm transition shadow-md shadow-purple-600/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span>Master Halaman Statis</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-semibold text-xs sm:text-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8" />
                    </svg>
                    <span>Ke Panel Admin</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Kartu Metrik Sistem --}}
    @php
        $totalUsers = \App\Models\User::count();
        $totalCategories = \App\Models\Category::count();
        $totalPages = \App\Models\Page::count();
        $totalPosts = \App\Models\Post::count();
        $totalSeries = \App\Models\Series::count();
        $storageLinked = file_exists(public_path('storage'));
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Total Users --}}
        <div class="bg-slate-950/80 p-5 rounded-2xl border border-slate-800 shadow-xl flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-mono uppercase tracking-wider text-slate-400">Total Pengguna</span>
                <div class="w-9 h-9 rounded-xl bg-purple-950/80 text-purple-400 flex items-center justify-center border border-purple-800/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-black font-mono text-white">{{ $totalUsers }}</div>
                <div class="text-xs text-slate-400 mt-1 font-mono">Penulis & Developer</div>
            </div>
        </div>

        {{-- Total Halaman Statis --}}
        <div class="bg-slate-950/80 p-5 rounded-2xl border border-slate-800 shadow-xl flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-mono uppercase tracking-wider text-slate-400">Master Halaman</span>
                <div class="w-9 h-9 rounded-xl bg-blue-950/80 text-blue-400 flex items-center justify-center border border-blue-800/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-black font-mono text-white">{{ $totalPages }}</div>
                <div class="text-xs text-purple-400 mt-1 font-mono">
                    <a href="{{ route('admin.developer.pages.index') }}" class="hover:underline">Kelola halaman &rarr;</a>
                </div>
            </div>
        </div>

        {{-- Total Artikel & Series --}}
        <div class="bg-slate-950/80 p-5 rounded-2xl border border-slate-800 shadow-xl flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-mono uppercase tracking-wider text-slate-400">Entitas Konten</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-950/80 text-indigo-400 flex items-center justify-center border border-indigo-800/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-black font-mono text-white">{{ $totalPosts + $totalSeries }}</div>
                <div class="text-xs text-slate-400 mt-1 font-mono">{{ $totalPosts }} artikel &bull; {{ $totalSeries }} series</div>
            </div>
        </div>

        {{-- Status Penyimpanan / Symlink --}}
        <div class="bg-slate-950/80 p-5 rounded-2xl border border-slate-800 shadow-xl flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-mono uppercase tracking-wider text-slate-400">Storage Link</span>
                <div class="w-9 h-9 rounded-xl {{ $storageLinked ? 'bg-emerald-950/80 text-emerald-400 border-emerald-800/40' : 'bg-rose-950/80 text-rose-400 border-rose-800/40' }} flex items-center justify-center border">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-xl font-bold font-mono {{ $storageLinked ? 'text-emerald-400' : 'text-rose-400' }}">
                    {{ $storageLinked ? 'Connected' : 'Missing' }}
                </div>
                <div class="text-xs text-slate-400 mt-1 font-mono">public/storage linked</div>
            </div>
        </div>
    </div>

    {{-- Detail Server & Environment --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Konfigurasi Server --}}
        <div class="bg-slate-950/80 rounded-2xl border border-slate-800 p-6 shadow-xl space-y-4">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                </svg>
                <h3 class="text-sm font-bold font-mono uppercase tracking-wider text-white">Spesifikasi Server & Runtime</h3>
            </div>

            <div class="divide-y divide-slate-800/80 text-xs font-mono">
                <div class="py-2.5 flex items-center justify-between">
                    <span class="text-slate-400">Framework</span>
                    <span class="text-purple-300 font-bold">Laravel v{{ app()->version() }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between">
                    <span class="text-slate-400">PHP Version</span>
                    <span class="text-slate-200">{{ phpversion() }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between">
                    <span class="text-slate-400">Environment</span>
                    <span class="px-2 py-0.5 rounded bg-blue-950 text-blue-300 border border-blue-800 uppercase">{{ app()->environment() }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between">
                    <span class="text-slate-400">Debug Mode</span>
                    <span class="{{ config('app.debug') ? 'text-amber-400' : 'text-emerald-400' }}">
                        {{ config('app.debug') ? 'ENABLED (True)' : 'DISABLED (False)' }}
                    </span>
                </div>
                <div class="py-2.5 flex items-center justify-between">
                    <span class="text-slate-400">Timezone</span>
                    <span class="text-slate-200">{{ config('app.timezone') }}</span>
                </div>
            </div>
        </div>

        {{-- Konfigurasi Database & Storage --}}
        <div class="bg-slate-950/80 rounded-2xl border border-slate-800 p-6 shadow-xl space-y-4">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3V7c0-2-1.5-3-3.5-3h-9C5.5 4 4 5 4 7zm0 5c0 2 1.5 3 3.5 3h9c2 0 3.5-1 3.5-3" />
                </svg>
                <h3 class="text-sm font-bold font-mono uppercase tracking-wider text-white">Database & File Storage</h3>
            </div>

            <div class="divide-y divide-slate-800/80 text-xs font-mono">
                <div class="py-2.5 flex items-center justify-between">
                    <span class="text-slate-400">DB Connection</span>
                    <span class="text-purple-300 font-bold uppercase">{{ config('database.default') }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between">
                    <span class="text-slate-400">Database Name</span>
                    <span class="text-slate-200">{{ config('database.connections.' . config('database.default') . '.database') }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between">
                    <span class="text-slate-400">Filesystem Default</span>
                    <span class="text-slate-200">{{ config('filesystems.default') }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between">
                    <span class="text-slate-400">Public Disk Root</span>
                    <span class="text-slate-400 truncate max-w-[220px]" title="{{ config('filesystems.disks.public.root') }}">{{ config('filesystems.disks.public.root') }}</span>
                </div>
                <div class="py-2.5 flex items-center justify-between">
                    <span class="text-slate-400">Session Driver</span>
                    <span class="text-slate-200">{{ config('session.driver') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection