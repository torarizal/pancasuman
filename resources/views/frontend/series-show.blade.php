@extends('layouts.app')

@section('title', $series->title . ' - Series - Pancasuman')

@section('content')
<div class="space-y-8">
    {{-- Header Info Series --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm">
        <div class="flex items-center space-x-2 mb-3">
            <span class="bg-purple-50 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full">
                {{ $series->category->name ?? 'Umum' }}
            </span>
            <span class="text-xs text-slate-400">Dibuat oleh <strong>{{ $series->author->name ?? 'Anonim' }}</strong></span>
        </div>
        <h1 class="text-3xl font-black text-slate-900 mb-4">{{ $series->title }}</h1>
        <p class="text-slate-600 leading-relaxed text-base">{{ $series->description }}</p>
    </div>

    {{-- Daftar Bab / Volume --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm">
        <h2 class="text-xl font-bold text-slate-900 mb-6 pb-2 border-b border-slate-100">Daftar Bab / Volume</h2>
        
        <div class="space-y-3">
            @forelse($posts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:border-blue-300 hover:bg-blue-50/50 transition group">
                <div class="flex items-center space-x-4">
                    <span class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center text-xs font-bold text-slate-600 transition">
                        {{ $post->volume_number ?? '-' }}
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 group-hover:text-blue-600 transition text-base">{{ $post->title }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <span class="text-xs font-semibold text-blue-600">&rarr; Baca</span>
            </a>
            @empty
            <p class="text-sm text-slate-400 text-center py-6">Belum ada bab yang dipublikasikan dalam series ini.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection