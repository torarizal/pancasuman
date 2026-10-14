@extends('layouts.app')

@section('title', $post->meta_title ?? $post->title . ' - Pancasuman')

@section('meta_description', $post->meta_description ?? $post->excerpt ?? Str::limit(strip_tags($post->body), 150))

@if($post->featured_image)
@section('og_image', asset('storage/' . $post->featured_image))
@endif

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    {{-- Breadcrumb Navigation --}}
    <nav class="flex items-center space-x-2 text-xs sm:text-sm text-slate-500 overflow-x-auto whitespace-nowrap pb-1">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
        <span>/</span>
        @if($post->category)
            <a href="{{ route('category.show', $post->category->slug) }}" class="hover:text-blue-600 transition-colors">
                {{ $post->category->name }}
            </a>
            <span>/</span>
        @endif
        <span class="text-slate-800 font-medium truncate max-w-[200px] sm:max-w-xs">{{ $post->title }}</span>
    </nav>

    {{-- Main Article Card --}}
    <article class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-12 shadow-sm relative overflow-hidden">
        
        {{-- Badges Kategori & Series --}}
        <div class="flex flex-wrap items-center gap-2.5 mb-6">
            @if($post->category)
                <a href="{{ route('category.show', $post->category->slug) }}" class="badge-primary text-xs font-semibold px-3 py-1.5 rounded-full transition hover:brightness-95 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                    <span>{{ $post->category->name }}</span>
                </a>
            @endif
            @if($post->series)
                <a href="{{ route('series.show', $post->series->slug) }}" class="badge-series text-xs font-semibold px-3 py-1.5 rounded-full transition hover:brightness-95 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Series: {{ $post->series->title }} @if($post->volume_number) (Vol. {{ $post->volume_number }}) @endif</span>
                </a>
            @endif
        </div>

        {{-- Judul Tulisan --}}
        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 font-serif tracking-tight mb-6 leading-tight">
            {{ $post->title }}
        </h1>

        {{-- Metadata Penulis, Tanggal, & Estimasi Waktu Baca --}}
        <div class="flex flex-wrap items-center justify-between gap-4 py-5 border-y border-slate-100 mb-8 text-xs sm:text-sm text-slate-500">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold flex items-center justify-center text-sm shadow-xs">
                    {{ substr($post->author->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <div class="text-slate-900 font-bold">
                        @if($post->author)
                            <a href="{{ route('authors.show', $post->author->id) }}" class="hover:text-blue-600 transition-colors">
                                {{ $post->author->name }}
                            </a>
                        @else
                            <span>Anonim</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 text-xs">
                        <span>{{ $post->published_at ? $post->published_at->format('d M Y H:i') : $post->created_at->format('d M Y') }}</span>
                        <span>&bull;</span>
                        <span>{{ max(1, (int) ceil(str_word_count(strip_tags($post->body)) / 180)) }} menit baca</span>
                    </div>
                </div>
            </div>

            {{-- Action Salin Tautan --}}
            <button type="button" onclick="copyArticleLink(this)" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50/50 transition-all text-xs font-medium cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span>Salin Tautan</span>
            </button>
        </div>

        {{-- Gambar Sampul / Featured Image --}}
        @if($post->featured_image)
        <div class="mb-8 overflow-hidden rounded-2xl border border-slate-200/80 shadow-xs">
            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full max-h-[500px] object-cover object-center">
        </div>
        @endif

        {{-- Navigasi Bab Series (Jika Bagian dari Series) --}}
        @if(count($seriesPosts) > 0)
        <div class="bg-gradient-to-br from-purple-50/80 to-indigo-50/50 border border-purple-200/80 rounded-2xl p-5 sm:p-6 mb-10 shadow-xs">
            <div class="flex items-center gap-2 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <h3 class="text-xs sm:text-sm font-bold text-purple-950 uppercase tracking-wider">
                    Daftar Bab dalam Series Ini:
                </h3>
            </div>
            <ul class="space-y-2 text-sm">
                @foreach($seriesPosts as $sp)
                <li>
                    <a href="{{ route('posts.show', $sp->slug) }}" class="flex items-center justify-between p-3 rounded-xl transition {{ $sp->id === $post->id ? 'bg-purple-600 text-white font-semibold shadow-sm' : 'bg-white/70 hover:bg-white text-purple-900 border border-purple-100 hover:border-purple-300' }}">
                        <span class="flex items-center gap-2">
                            <span class="inline-block w-6 text-center text-xs opacity-75 font-mono">Vol. {{ $sp->volume_number ?? '-' }}</span>
                            <span>{{ $sp->title }}</span>
                        </span>
                        @if($sp->id === $post->id)
                            <span class="text-xs bg-white text-purple-700 px-2.5 py-0.5 rounded-full font-bold shadow-xs">Sedang Dibaca</span>
                        @endif
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Isi Konten Tulisan --}}
        <div class="prose-editorial max-w-none text-slate-800 leading-relaxed font-sans text-base sm:text-lg">
            {!! $post->body !!}
        </div>

        {{-- Bagian Bawah Artikel: Share & Author Card --}}
        <div class="mt-12 pt-8 border-t border-slate-100 space-y-6">
            
            {{-- Share Buttons --}}
            <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                <div class="text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    <span>Bagikan tulisan ini:</span>
                </div>
                <div class="flex items-center gap-2">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . url()->current()) }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-lg bg-emerald-500 text-white text-xs font-semibold hover:bg-emerald-600 transition flex items-center gap-1">
                        <span>WhatsApp</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition flex items-center gap-1">
                        <span>X / Twitter</span>
                    </a>
                    <button type="button" onclick="copyArticleLink(this)" class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-100 transition">
                        <span>Salin Link</span>
                    </button>
                </div>
            </div>

            {{-- Kartu Penulis Ringkas --}}
            @if($post->author)
            <div class="flex items-center gap-4 p-5 rounded-2xl bg-white border border-slate-200/80 shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-black flex items-center justify-center text-xl shadow-xs shrink-0">
                    {{ substr($post->author->name, 0, 1) }}
                </div>
                <div class="space-y-1">
                    <div class="text-xs font-semibold uppercase tracking-wider text-blue-600">Tentang Penulis</div>
                    <h4 class="text-base font-bold text-slate-900">{{ $post->author->name }}</h4>
                    <p class="text-xs text-slate-500">Kontributor literasi di komunitas Pancasuman.</p>
                </div>
                <div class="ml-auto shrink-0">
                    <a href="{{ route('authors.show', $post->author->id) }}" class="text-xs font-semibold text-blue-600 hover:underline">
                        Lihat Karya &rarr;
                    </a>
                </div>
            </div>
            @endif

            {{-- Tombol Kembali --}}
            <div class="pt-4 flex items-center justify-between">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-blue-600 group transition-colors">
                    <span class="group-hover:-translate-x-1 transition-transform">&larr;</span>
                    <span>Kembali ke Beranda</span>
                </a>
                <a href="{{ route('archive') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:underline">
                    <span>Eksplor Tulisan Lainnya</span>
                    <span>&rarr;</span>
                </a>
            </div>

        </div>

    </article>

</div>
@endsection