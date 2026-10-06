@extends('layouts.app')

@section('title', 'Rubrik ' . $category->name . ' - Pancasuman')

@section('content')
<div class="space-y-6">
    <div class="border-b border-slate-200 pb-4">
        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Rubrik</span>
        <h1 class="text-2xl font-black text-slate-900 mt-2">{{ $category->name }}</h1>
        <p class="text-sm text-slate-500">{{ $category->description ?? 'Kumpulan tulisan dalam rubrik ini.' }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($posts as $post)
        <article class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div class="p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-2 leading-snug">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600 transition">
                        {{ $post->title }}
                    </a>
                </h2>
                <p class="text-slate-600 text-sm line-clamp-3 mb-4">
                    {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 120) }}
                </p>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Oleh <strong class="text-slate-700">{{ $post->author->name ?? 'Anonim' }}</strong></span>
                <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
            </div>
        </article>
        @empty
        <div class="col-span-3 text-center py-12 bg-white rounded-xl border border-slate-200">
            <p class="text-slate-400">Belum ada tulisan di rubrik ini.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection