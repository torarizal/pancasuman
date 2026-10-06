@extends('layouts.app')

@section('title', $author->name . ' - Penulis Pancasuman')

@section('content')
<div class="space-y-8">
    {{-- Header Profil Penulis --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-8 sm:p-12 shadow-sm text-center">
        <div class="w-32 h-32 mx-auto bg-gradient-to-tr from-blue-500 to-purple-500 text-white rounded-full flex items-center justify-center text-5xl font-black mb-6 shadow-lg">
            {{ substr($author->name, 0, 1) }}
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 mb-2">{{ $author->name }}</h1>
        <p class="text-slate-500">Anggota sejak {{ $author->created_at->format('M Y') }}</p>
    </div>

    {{-- Daftar Karya Penulis --}}
    <div>
        <h2 class="text-xl font-bold text-slate-800 mb-6 border-b border-slate-200 pb-2">Karya oleh {{ $author->name }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($posts as $post)
            <article class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition p-5">
                <a href="{{ route('category.show', $post->category->slug ?? '#') }}" class="text-xs font-bold text-blue-600 uppercase tracking-wider hover:underline mb-2 block">
                    {{ $post->category->name ?? 'Umum' }}
                </a>
                <h3 class="text-lg font-bold text-slate-900 mb-2 leading-snug">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600 transition">
                        {{ $post->title }}
                    </a>
                </h3>
                <p class="text-slate-500 text-sm line-clamp-2 mb-4">
                    {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 80) }}
                </p>
                <div class="text-xs text-slate-400">
                    Dipublikasikan pada {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-8 text-slate-400 bg-white rounded-xl border border-slate-200">
                Penulis ini belum memiliki karya yang dipublikasikan.
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection