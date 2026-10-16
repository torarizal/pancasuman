@extends('layouts.app')

@section('title', $series->title . ' - Series - Pancasuman')

@if($series->cover_image)
@section('og_image', asset('storage/' . $series->cover_image))
@endif

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    {{-- Breadcrumbs --}}
    <nav class="flex items-center space-x-2 text-xs sm:text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('series.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Master Series</a>
        <span>/</span>
        <span class="text-slate-800 dark:text-slate-200 font-medium truncate max-w-xs">{{ $series->title }}</span>
    </nav>

    {{-- Header Info Series --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xs relative overflow-hidden">
        @if($series->cover_image)
        <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs">
            <img src="{{ asset('storage/' . $series->cover_image) }}" alt="{{ $series->title }}" fetchpriority="high" decoding="async" class="w-full max-h-[400px] object-cover object-center">
        </div>
        @endif
        <div class="flex flex-wrap items-center gap-3 mb-4">
            <span class="badge-series text-xs font-semibold px-3 py-1 rounded-full">
                {{ $series->category->name ?? 'Umum' }}
            </span>
            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <span>Ditulis oleh</span>
                <span class="font-bold text-slate-800 dark:text-slate-200">{{ $series->author->name ?? 'Anonim' }}</span>
            </div>
        </div>
        
        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-slate-100 font-serif tracking-tight mb-4 leading-tight">
            {{ $series->title }}
        </h1>
        
        @if($series->description)
        <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm sm:text-base">
            {{ $series->description }}
        </p>
        @endif
    </div>

    {{-- Daftar Bab / Volume --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xs">
        <div class="flex items-center gap-2 mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">Daftar Bab & Volume</h2>
        </div>
        
        <div class="space-y-3">
            @forelse($posts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="flex items-center justify-between p-4 rounded-2xl border border-slate-100 dark:border-slate-800 hover:border-purple-300 dark:hover:border-purple-600/50 hover:bg-purple-50/40 dark:hover:bg-purple-950/20 transition group">
                <div class="flex items-center space-x-4">
                    <span class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-purple-950/50 group-hover:bg-purple-600 dark:group-hover:bg-purple-500 group-hover:text-white flex items-center justify-center text-xs font-bold text-purple-700 dark:text-purple-300 transition-colors shadow-2xs">
                        {{ $post->volume_number ?? '-' }}
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-purple-700 dark:group-hover:text-purple-300 transition text-sm sm:text-base">{{ $post->title }}</h3>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1 text-xs font-semibold text-purple-700 dark:text-purple-400 group-hover:translate-x-1 transition-transform">
                    <span>Baca</span>
                    <span>&rarr;</span>
                </div>
            </a>
            @empty
            <div class="text-center py-12 text-slate-400 dark:text-slate-500 text-sm">
                Belum ada bab yang dipublikasikan dalam series ini.
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection