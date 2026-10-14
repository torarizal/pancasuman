@extends('layouts.admin')

@section('title', 'Dashboard Admin - Pancasuman')
@section('header', 'Dashboard Utama')

@section('content')
<div class="space-y-8">
    
    {{-- Banner Selamat Datang & Quick Actions --}}
    <div class="bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-blue-800/40">
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-blue-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>Sesi Aktif: {{ auth()->user()->role ?? 'Admin' }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black font-serif tracking-tight text-white">
                    Selamat datang kembali, {{ auth()->user()->name }}!
                </h2>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                    Kelola artikel, master series bertema, dan rubrikasi Pancasuman. Pantau status publikasi tulisan melalui dashboard ini.
                </p>
            </div>

            {{-- Action Buttons yang Berfungsi Penuh --}}
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs sm:text-sm transition shadow-md shadow-blue-600/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tulis Artikel Baru</span>
                </a>

                <a href="{{ route('admin.series.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs sm:text-sm transition shadow-md shadow-purple-600/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Buat Series Baru</span>
                </a>

                @if(auth()->user()->isDeveloper())
                    <a href="{{ route('admin.developer.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/20 font-semibold text-xs sm:text-sm transition backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                        <span>Developer Console</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Kartu Statistik Real Time --}}
    @php
        $totalPosts = \App\Models\Post::count();
        $publishedPosts = \App\Models\Post::where('status', 'published')->count();
        $draftPosts = \App\Models\Post::where('status', 'draft')->count();
        $totalSeries = \App\Models\Series::count();
        $totalCategories = \App\Models\Category::count();
        $myPosts = \App\Models\Post::where('user_id', auth()->id())->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Total Artikel --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-2xs hover:border-blue-300 transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Artikel</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-black text-slate-900 tracking-tight">{{ $totalPosts }}</div>
                <div class="flex items-center gap-2 mt-1.5 text-xs text-slate-500">
                    <span class="text-emerald-600 font-semibold">{{ $publishedPosts }} terbit</span>
                    <span>&bull;</span>
                    <span class="text-amber-600 font-semibold">{{ $draftPosts }} draft</span>
                </div>
            </div>
        </div>

        {{-- Total Master Series --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-2xs hover:border-purple-300 transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Master Series</span>
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-black text-slate-900 tracking-tight">{{ $totalSeries }}</div>
                <div class="text-xs text-purple-600 font-medium mt-1.5 flex items-center gap-1">
                    <a href="{{ route('admin.series.index') }}" class="hover:underline">Lihat semua series &rarr;</a>
                </div>
            </div>
        </div>

        {{-- Total Kategori Rubrik --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-2xs hover:border-blue-300 transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Rubrik / Kategori</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-black text-slate-900 tracking-tight">{{ $totalCategories }}</div>
                <div class="text-xs text-indigo-600 font-medium mt-1.5 flex items-center gap-1">
                    <a href="{{ route('admin.categories.index') }}" class="hover:underline">Kelola rubrik &rarr;</a>
                </div>
            </div>
        </div>

        {{-- Tulisan Saya --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-2xs hover:border-emerald-300 transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Tulisan Saya</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl font-black text-slate-900 tracking-tight">{{ $myPosts }}</div>
                <div class="text-xs text-emerald-600 font-medium mt-1.5 flex items-center gap-1">
                    <span>Kontribusi aktif Anda</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Artikel Terbaru --}}
    @php
        $recentPosts = \App\Models\Post::with(['category', 'series', 'author'])->latest()->take(5)->get();
    @endphp

    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">Tulisan Terbaru</h3>
                <p class="text-xs text-slate-400 mt-0.5">5 artikel terakhir yang didaftarkan ke sistem.</p>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1">
                <span>Buka Semua Artikel</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Artikel / Judul</th>
                        <th class="p-4">Rubrik</th>
                        <th class="p-4">Series</th>
                        <th class="p-4">Penulis</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentPosts as $post)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="" loading="lazy" decoding="async" class="w-10 h-10 rounded-xl object-cover border border-slate-200 shrink-0 shadow-2xs">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200/80 flex items-center justify-center text-slate-400 shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="font-bold text-slate-800 hover:text-blue-600 transition block truncate max-w-xs sm:max-w-sm">
                                        {{ $post->title }}
                                    </a>
                                    <span class="text-xs text-slate-400 font-mono block">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $post->category->name ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="p-4 text-xs text-slate-600">
                            @if($post->series)
                                <span class="font-semibold text-purple-700">{{ $post->series->title }}</span>
                                @if($post->volume_number)
                                    <span class="text-[10px] bg-purple-100 text-purple-800 px-1.5 py-0.5 rounded font-bold ml-1">Vol. {{ $post->volume_number }}</span>
                                @endif
                            @else
                                <span class="text-slate-400">Tulisan Lepas</span>
                            @endif
                        </td>
                        <td class="p-4 text-xs text-slate-600 font-medium">
                            {{ $post->author->name ?? 'Anonim' }}
                        </td>
                        <td class="p-4">
                            @if($post->status === 'published')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Published</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    <span>Draft</span>
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 hover:text-blue-600 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Edit</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400 text-sm">
                            Belum ada artikel yang dibuat. Silakan klik tombol "Tulis Artikel Baru" di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection