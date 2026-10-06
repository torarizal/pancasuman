@extends('layouts.app')

@section('title', $post->title . ' - Pancasuman')

@section('content')
<div class="max-w-3xl mx-auto bg-white border border-slate-200 rounded-2xl p-8 sm:p-12 shadow-sm">
    
    {{-- Navigasi Atas / Kategori & Series --}}
    <div class="flex flex-wrap items-center gap-2 mb-4">
        <a href="{{ route('category.show', $post->category->slug ?? '#') }}" class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
            {{ $post->category->name ?? 'Umum' }}
        </a>
        @if($post->series)
            <a href="{{ route('series.show', $post->series->slug) }}" class="bg-purple-50 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full">
                Series: {{ $post->series->title }} @if($post->volume_number) (Vol. {{ $post->volume_number }}) @endif
            </a>
        @endif
    </div>

    {{-- Judul Tulisan --}}
    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-4 leading-tight">
        {{ $post->title }}
    </h1>

    {{-- Metadata Penulis & Tanggal --}}
    <div class="flex items-center space-x-4 border-b border-slate-200 pb-6 mb-8 text-sm text-slate-500">
        <div>Ditulis oleh <strong class="text-slate-800">{{ $post->author->name ?? 'Anonim' }}</strong></div>
        <span>&bull;</span>
        <div>{{ $post->published_at ? $post->published_at->format('d M Y H:i') : $post->created_at->format('d M Y') }}</div>
    </div>

    {{-- Navigasi Cerpen Bersambung (Jika Bagian dari Series) --}}
    @if(count($seriesPosts) > 0)
    <div class="bg-purple-50 border border-purple-200 rounded-xl p-6 mb-8">
        <h3 class="text-sm font-bold text-purple-900 mb-3 uppercase tracking-wider">Daftar Bab / Volume dalam Series Ini:</h3>
        <ul class="space-y-2 text-sm">
            @foreach($seriesPosts as $sp)
            <li>
                <a href="{{ route('posts.show', $sp->slug) }}" class="flex items-center justify-between p-2 rounded-lg transition {{ $sp->id === $post->id ? 'bg-purple-600 text-white font-semibold' : 'hover:bg-purple-100 text-purple-900' }}">
                    <span>Vol. {{ $sp->volume_number ?? '-' }} — {{ $sp->title }}</span>
                    @if($sp->id === $post->id)
                        <span class="text-xs bg-white text-purple-700 px-2 py-0.5 rounded font-bold">Sedang Dibaca</span>
                    @endif
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Isi Konten Artikel / Cerpen --}}
    <div class="prose prose-slate max-w-none text-slate-800 leading-relaxed space-y-6 text-base sm:text-lg">
        {!! nl2br(e($post->body)) !!}
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-12 pt-6 border-t border-slate-200">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:underline">
            &larr; Kembali ke Beranda
        </a>
    </div>

</div>
@endsection