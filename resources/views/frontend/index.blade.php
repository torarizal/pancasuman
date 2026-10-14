@extends('layouts.app')

@section('title', 'Beranda - Pancasuman Community Portal')

@section('content')
<div class="space-y-10">

    {{-- Hero Banner / Editorial Header --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 text-white p-8 sm:p-12 shadow-xl border border-slate-800">
        {{-- Subtle ambient glow inside hero --}}
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-blue-200">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span>Komunitas Maiyah & Literasi Pancasuman</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight text-white font-serif">
                Menghidupkan Gagasan, Merawat Nurani Lewat Tulisan.
            </h1>

            <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-2xl font-sans">
                Kumpulan esai, refleksi budaya, dan cerpen bersambung karya jamaah dan sahabat literasi. Menemukan kejernihan di tengah keriuhan.
            </p>

            <div class="pt-2 flex flex-wrap items-center gap-3">
                <a href="{{ route('archive') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-xs sm:text-sm font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-blue-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Jelajahi Arsip</span>
                </a>
                <a href="{{ route('biografi.caknun') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/15 text-slate-200 hover:text-white text-xs sm:text-sm font-semibold px-5 py-2.5 rounded-xl border border-white/10 backdrop-blur-md transition-all">
                    <span>Biografi Cak Nun</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Grid Konten Utama & Sidebar --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 sm:gap-10">
        
        {{-- Kolom Utama: Daftar Artikel & Cerpen Terbaru --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="flex items-center justify-between pb-4 border-b border-slate-200/80">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Karya Terbaru</h2>
                        <p class="text-xs sm:text-sm text-slate-500">Esai, pemikiran, dan cerpen bersambung terkini</p>
                    </div>
                </div>
                <a href="{{ route('archive') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1">
                    <span>Semua Tulisan</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($posts as $post)
                <article class="card-lift bg-white border border-slate-200/80 hover:border-blue-300 rounded-2xl overflow-hidden shadow-xs flex flex-col justify-between group transition-all duration-300">
                    @if($post->featured_image)
                    <div class="h-48 w-full overflow-hidden bg-slate-100">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    @endif
                    <div class="p-6">
                        {{-- Kategori & Series Badges --}}
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <a href="{{ route('category.show', $post->category->slug ?? '#') }}" class="badge-primary text-xs font-semibold px-2.5 py-1 rounded-full transition hover:brightness-95 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                <span>{{ $post->category->name ?? 'Umum' }}</span>
                            </a>
                            @if($post->series)
                                <a href="{{ route('series.show', $post->series->slug) }}" class="badge-series text-xs font-semibold px-2.5 py-1 rounded-full transition hover:brightness-95 truncate max-w-[170px] flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-purple-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span>{{ $post->series->title }}</span>
                                </a>
                            @endif
                        </div>
                        
                        {{-- Judul Post --}}
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mb-2.5 leading-snug">
                            <a href="{{ route('posts.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        
                        {{-- Excerpt --}}
                        <p class="text-slate-600 text-sm line-clamp-3 leading-relaxed mb-4">
                            {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 120) }}
                        </p>
                    </div>

                    {{-- Card Footer --}}
                    <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-[10px]">
                                {{ substr($post->author->name ?? 'A', 0, 1) }}
                            </div>
                            <span class="truncate max-w-[110px] text-slate-700 font-medium">
                                {{ $post->author->name ?? 'Anonim' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center gap-1.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-2 text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200">
                    <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium text-sm">Belum ada karya yang dipublikasikan.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>

        {{-- Kolom Samping (Sidebar) --}}
        <div class="space-y-8">
            
            {{-- Widget Rubrik / Kategori --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h3 class="text-base font-bold text-slate-900">Kategori Tulisan</h3>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" class="bg-slate-50 hover:bg-blue-600 hover:text-white text-slate-700 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200/70 hover:border-blue-600 transition-all duration-200 flex items-center gap-1.5">
                            <span>{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Widget Master Series Terbaru --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-xs">
                <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="text-base font-bold text-slate-900">Master Series</h3>
                    </div>
                    <a href="{{ route('series.index') }}" class="text-xs text-blue-600 hover:underline font-semibold">Lihat Semua &rarr;</a>
                </div>
                
                <div class="space-y-3.5">
                    @forelse($seriesList as $series)
                    <div class="p-3 rounded-xl bg-slate-50/70 hover:bg-purple-50/50 border border-slate-100 hover:border-purple-200 transition-all group flex items-center gap-3">
                        @if($series->cover_image)
                            <img src="{{ asset('storage/' . $series->cover_image) }}" alt="{{ $series->title }}" class="w-12 h-12 rounded-lg object-cover shrink-0 border border-slate-200/80">
                        @endif
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('series.show', $series->slug) }}" class="block font-semibold text-slate-800 group-hover:text-purple-700 transition text-sm truncate">
                                {{ $series->title }}
                            </a>
                            <p class="text-xs text-slate-400 mt-1 flex items-center justify-between">
                                <span class="truncate">Oleh {{ $series->author->name ?? 'Anonim' }}</span>
                                <span class="text-purple-600 font-medium group-hover:underline shrink-0 ml-2">Buka bab &rarr;</span>
                            </p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 py-3 text-center">Belum ada master series.</p>
                    @endforelse
                </div>
            </div>

            {{-- Widget Mutiara Kata / Kutipan Budaya --}}
            <div class="rounded-2xl p-6 bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200/70 shadow-xs relative overflow-hidden">
                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                </div>
                <blockquote class="text-xs sm:text-sm text-slate-700 italic leading-relaxed font-serif">
                    "Kebaikan tidak pernah membutuhkan pengumuman. Ia menyusup ke dalam hati mereka yang mencari keteduhan."
                </blockquote>
                <div class="mt-3 text-[11px] font-bold text-amber-900 uppercase tracking-wider">
                    — Cak Nun (Emha Ainun Nadjib)
                </div>
            </div>

        </div>

    </div>

</div>
@endsection