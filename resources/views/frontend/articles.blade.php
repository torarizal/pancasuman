@extends('layouts.app')

@section('title', 'Kumpulan Artikel - Pancasuman')

@section('content')
<div class="space-y-8">
    
    {{-- Header & Form Pencarian Khusus Artikel --}}
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-10 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">
        <div class="space-y-1.5 max-w-xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                <span>Rubrikasi & Tulisan</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 font-serif tracking-tight">Kumpulan Artikel & Esai</h1>
            <p class="text-slate-500 text-sm leading-relaxed">Menampilkan esai pemikiran, refleksi sastra, dan tulisan informatif pilihan kontributor.</p>
        </div>
        
        <div class="w-full md:w-80 shrink-0">
            <form action="{{ route('articles') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel..." class="w-full pl-4 pr-12 py-3 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">
                <button type="submit" aria-label="Cari" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-slate-400 hover:text-blue-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
            @if(request('search'))
                <div class="mt-2 text-xs text-slate-500 flex items-center justify-between">
                    <span>Hasil pencarian: "{{ request('search') }}"</span>
                    <a href="{{ route('articles') }}" class="text-blue-600 hover:underline font-medium">Reset</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Daftar Artikel --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($posts as $post)
        <article class="card-lift bg-white border border-slate-200/80 hover:border-blue-300 rounded-2xl overflow-hidden shadow-xs flex flex-col justify-between group transition-all duration-300">
            @if($post->featured_image)
            <div class="h-44 w-full overflow-hidden bg-slate-100">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            @endif
            <div class="p-6">
                <div class="mb-3">
                    <span class="badge-primary text-[11px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider inline-block">
                        {{ $post->category->name ?? 'Artikel' }}
                    </span>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-blue-600 transition mb-2.5 leading-snug">
                    <a href="{{ route('posts.show', $post->slug) }}">
                        {{ $post->title }}
                    </a>
                </h3>
                <p class="text-slate-500 text-sm line-clamp-3 leading-relaxed mb-4">
                    {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 100) }}
                </p>
            </div>
            
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <div class="flex items-center gap-2 truncate pr-2">
                    <div class="w-5 h-5 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-[9px] shrink-0">
                        {{ substr($post->author->name ?? 'A', 0, 1) }}
                    </div>
                    <span class="truncate font-medium text-slate-700">{{ $post->author->name ?? 'Anonim' }}</span>
                </div>
                <span class="shrink-0 text-slate-400">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
            </div>
        </article>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200 space-y-3">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-slate-600 font-medium text-sm">Tidak ada artikel yang ditemukan.</p>
            @if(request('search'))
                <a href="{{ route('articles') }}" class="inline-block text-xs font-semibold text-blue-600 hover:underline">
                    Reset kata kunci pencarian
                </a>
            @endif
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection