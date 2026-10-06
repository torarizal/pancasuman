@extends('layouts.app')

@section('title', 'Beranda - Pancasuman Community Portal')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    {{-- Kolom Utama: Daftar Artikel & Cerpen Terbaru --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="border-b border-slate-200 pb-4 mb-6">
            <h1 class="text-2xl font-black text-slate-900">Tulisan & Karya Terbaru</h1>
            <p class="text-sm text-slate-500">Esai, pemikiran, dan cerpen bersambung dari komunitas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($posts as $post)
            <article class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                <div class="p-6">
                    <div class="flex items-center space-x-2 mb-3">
                        <a href="{{ route('category.show', $post->category->slug ?? '#') }}" class="bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-semibold px-2.5 py-1 rounded-full transition">
                            {{ $post->category->name ?? 'Umum' }}
                        </a>
                        @if($post->series)
                            <a href="{{ route('series.show', $post->series->slug) }}" class="bg-purple-50 text-purple-700 hover:bg-purple-100 text-xs font-semibold px-2.5 py-1 rounded-full transition truncate max-w-[150px]">
                                {{ $post->series->title }}
                            </a>
                        @endif
                    </div>
                    
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
            <div class="col-span-2 text-center py-12 bg-white rounded-xl border border-slate-200">
                <p class="text-slate-400">Belum ada artikel atau cerpen yang dipublikasikan.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>

    {{-- Kolom Samping (Sidebar): Rubrik & Master Series --}}
    <div class="space-y-8">
        
        {{-- Widget Rubrik / Kategori --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Rubrik / Kategori</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 text-xs font-medium px-3 py-1.5 rounded-lg transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Widget Master Series Terbaru --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-4 pb-2 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900">Master Series</h3>
                <a href="{{ route('series.index') }}" class="text-xs text-blue-600 hover:underline font-semibold">Lihat Semua</a>
            </div>
            
            <div class="space-y-4">
                @forelse($seriesList as $series)
                <div class="group">
                    <a href="{{ route('series.show', $series->slug) }}" class="block font-semibold text-slate-800 group-hover:text-blue-600 transition text-sm">
                        {{ $series->title }}
                    </a>
                    <p class="text-xs text-slate-400 mt-0.5">Oleh {{ $series->author->name ?? 'Anonim' }}</p>
                </div>
                @empty
                <p class="text-xs text-slate-400">Belum ada master series.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection