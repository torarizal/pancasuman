@extends('layouts.app')

@section('title', 'Arsip Tulisan - Pancasuman')

@section('content')
<div class="space-y-8">
    
    {{-- Header & Form Pencarian & Filter Rubrik --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xs flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 relative overflow-hidden">
        <div class="space-y-1.5 max-w-lg">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 text-xs font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <span>Arsip Lengkap</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-slate-100 font-serif tracking-tight">Arsip Karya & Tulisan</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">Jelajahi seluruh karya, refleksi esai, dan cerpen bersambung yang tersimpan rapi.</p>
        </div>
        
        {{-- Form Pencarian & Filter --}}
        <form action="{{ route('archive') }}" method="GET" class="w-full lg:w-auto flex flex-col sm:flex-row gap-3 shrink-0">
            {{-- Input Kata Kunci --}}
            <div class="relative sm:w-64 lg:w-72">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul / isi tulisan..." class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">
                <button type="submit" aria-label="Cari" class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

            {{-- Dropdown Filter Rubrik --}}
            <div class="sm:w-48">
                <select name="category" onchange="this.form.submit()" class="w-full py-2.5 px-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Reset jika ada filter aktif --}}
            @if(request()->filled('search') || request()->filled('category'))
                <a href="{{ route('archive') }}" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Reset</span>
                </a>
            @endif
        </form>
    </div>

    {{-- Informasi Filter Aktif --}}
    @if(request()->filled('search') || request()->filled('category'))
        <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 bg-white/70 dark:bg-slate-900/70 border border-slate-200/80 dark:border-slate-800 rounded-2xl px-5 py-3">
            <span class="font-medium text-slate-500 dark:text-slate-400">Filter diterapkan:</span>
            @if(request()->filled('search'))
                <span class="bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-xs font-semibold border border-blue-200/60 dark:border-blue-800/60 flex items-center gap-1">
                    <span>Kata Kunci: "{{ request('search') }}"</span>
                </span>
            @endif
            @if(request()->filled('category'))
                @php $currentCat = $categories->firstWhere('id', request('category')); @endphp
                @if($currentCat)
                    <span class="bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-xs font-semibold border border-blue-200/60 dark:border-blue-800/60 flex items-center gap-1">
                        <span>Kategori: {{ $currentCat->name }}</span>
                    </span>
                @endif
            @endif
        </div>
    @endif

    {{-- Hasil Pencarian / Daftar Tulisan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($posts as $post)
        <article class="card-lift bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:border-blue-300 dark:hover:border-blue-500/50 rounded-2xl overflow-hidden shadow-xs flex flex-col justify-between group transition-all duration-300">
            @if($post->featured_image)
            <div class="h-44 w-full overflow-hidden bg-slate-100 dark:bg-slate-800">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            @endif
            <div class="p-6">
                <div class="mb-3">
                    <a href="{{ route('category.show', $post->category->slug ?? '#') }}" class="badge-primary text-[11px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider inline-block transition hover:brightness-95">
                        {{ $post->category->name ?? 'Umum' }}
                    </a>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition mb-2.5 leading-snug">
                    <a href="{{ route('posts.show', $post->slug) }}">
                        {{ $post->title }}
                    </a>
                </h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-3 leading-relaxed mb-4">
                    {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 100) }}
                </p>
            </div>
            
            <div class="px-6 py-4 bg-slate-50/70 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                <div class="flex items-center gap-2 truncate pr-2">
                    <div class="w-5 h-5 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-[9px] shrink-0">
                        {{ substr($post->author->name ?? 'A', 0, 1) }}
                    </div>
                    <span class="truncate font-medium text-slate-700 dark:text-slate-300">{{ $post->author->name ?? 'Anonim' }}</span>
                </div>
                <span class="shrink-0 text-slate-400">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
            </div>
        </article>
        @empty
        <div class="col-span-full text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 space-y-3">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-slate-600 dark:text-slate-300 font-medium text-sm">Tidak ada tulisan yang cocok dengan filter pencarian tersebut.</p>
            <a href="{{ route('archive') }}" class="inline-block text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                Reset Pencarian & Filter
            </a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection