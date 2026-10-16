@extends('layouts.app')

@section('title', $author->name . ' - Penulis Pancasuman')

@section('content')
<div class="max-w-5xl mx-auto space-y-10">
    
    {{-- Breadcrumbs --}}
    <nav class="flex items-center space-x-2 text-xs sm:text-sm text-slate-500 dark:text-slate-400">
        <a href="{{ route('home') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('authors.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Penulis</a>
        <span>/</span>
        <span class="text-slate-800 dark:text-slate-200 font-medium">{{ $author->name }}</span>
    </nav>

    {{-- Header Profil Penulis --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-8 sm:p-12 shadow-xs text-center relative overflow-hidden">
        <div class="w-28 h-28 mx-auto bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 text-white rounded-3xl flex items-center justify-center text-4xl font-black mb-5 shadow-lg shadow-blue-500/20 ring-4 ring-white dark:ring-slate-800 border border-slate-100 dark:border-slate-700">
            {{ substr($author->name, 0, 1) }}
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-slate-100 font-serif tracking-tight mb-2">{{ $author->name }}</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Bergabung sejak {{ $author->created_at->format('M Y') }} &bull; Kontributor Literasi Pancasuman</p>
    </div>

    {{-- Daftar Karya Penulis --}}
    <div class="space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200/80 dark:border-slate-800">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">Karya oleh {{ $author->name }}</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
            <article class="card-lift bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:border-blue-300 dark:hover:border-blue-500/50 rounded-2xl overflow-hidden shadow-xs flex flex-col justify-between group transition-all duration-300">
                @if($post->featured_image)
                <div class="h-44 w-full overflow-hidden bg-slate-100 dark:bg-slate-800">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                @endif
                <div class="p-6">
                    <div class="mb-3">
                        <a href="{{ route('category.show', $post->category->slug ?? '#') }}" class="badge-primary text-[11px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider inline-block">
                            {{ $post->category->name ?? 'Umum' }}
                        </a>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mb-2.5 leading-snug">
                        <a href="{{ route('posts.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 leading-relaxed mb-4">
                        {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 100) }}
                    </p>
                </div>
                
                <div class="px-6 py-4 bg-slate-50/70 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-400 dark:text-slate-500">
                    <span>Dipublikasikan</span>
                    <span class="font-medium text-slate-600 dark:text-slate-300">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 space-y-3">
                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <p class="text-slate-500 dark:text-slate-400 font-medium text-sm">Penulis ini belum memiliki karya yang dipublikasikan.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection