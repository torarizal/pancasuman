@extends('layouts.app')

@section('title', 'Rubrik ' . $category->name . ' - Pancasuman')

@section('content')
<div class="space-y-8">
    
    {{-- Breadcrumbs --}}
    <nav class="flex items-center space-x-2 text-xs sm:text-sm text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('archive') }}" class="hover:text-blue-600 transition-colors">Rubrik</a>
        <span>/</span>
        <span class="text-slate-800 font-medium">{{ $category->name }}</span>
    </nav>

    {{-- Header Rubrik --}}
    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-10 shadow-xs relative overflow-hidden">
        <div class="space-y-2 max-w-2xl">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full badge-primary text-xs font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                <span>Rubrik Kategori</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 font-serif tracking-tight">{{ $category->name }}</h1>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed">
                {{ $category->description ?? 'Kumpulan esai, karya sastra, dan tulisan yang dihimpun dalam rubrik ini.' }}
            </p>
        </div>
    </div>

    {{-- Grid Tulisan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
        <article class="card-lift bg-white border border-slate-200/80 hover:border-blue-300 rounded-2xl overflow-hidden shadow-xs flex flex-col justify-between group transition-all duration-300">
            @if($post->featured_image)
            <div class="h-44 w-full overflow-hidden bg-slate-100">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            @endif
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mb-2.5 leading-snug">
                    <a href="{{ route('posts.show', $post->slug) }}">
                        {{ $post->title }}
                    </a>
                </h3>
                <p class="text-slate-600 text-sm line-clamp-3 leading-relaxed mb-4">
                    {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 120) }}
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
            </div>
            <p class="text-slate-500 font-medium text-sm">Belum ada karya yang dipublikasikan dalam rubrik ini.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection