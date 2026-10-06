@extends('layouts.app')

@section('title', 'Arsip Tulisan - Pancasuman')

@section('content')
<div class="space-y-8">
    {{-- Header & Form Pencarian --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900">Arsip Tulisan</h1>
            <p class="text-slate-500 mt-2">Jelajahi seluruh artikel, esai, dan cerpen di Pancasuman.</p>
        </div>
        
        <div class="w-full md:w-1/3">
            <form action="{{ route('archive') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau isi tulisan..." class="w-full pl-4 pr-12 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- Hasil Pencarian / Daftar Tulisan --}}
    @if(request()->filled('search'))
        <div class="text-sm text-slate-600">
            Menampilkan hasil pencarian untuk: <strong class="text-slate-900">"{{ request('search') }}"</strong>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($posts as $post)
        <article class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div class="p-5">
                <div class="mb-3">
                    <a href="{{ route('category.show', $post->category->slug ?? '#') }}" class="text-xs font-bold text-blue-600 uppercase tracking-wider hover:underline">
                        {{ $post->category->name ?? 'Umum' }}
                    </a>
                </div>
                <h2 class="text-lg font-bold text-slate-900 mb-2 leading-snug">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600 transition">
                        {{ $post->title }}
                    </a>
                </h2>
                <p class="text-slate-500 text-sm line-clamp-2">
                    {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 80) }}
                </p>
            </div>
            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span class="truncate pr-2">Oleh <strong>{{ $post->author->name ?? 'Anonim' }}</strong></span>
                <span>{{ $post->published_at ? $post->published_at->format('d M y') : $post->created_at->format('d M y') }}</span>
            </div>
        </article>
        @empty
        <div class="col-span-full text-center py-12 bg-white rounded-xl border border-slate-200">
            <p class="text-slate-500 text-lg">Oops! Tidak ada tulisan yang ditemukan.</p>
            @if(request()->filled('search'))
                <a href="{{ route('archive') }}" class="text-blue-600 hover:underline mt-2 inline-block">Reset Pencarian</a>
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