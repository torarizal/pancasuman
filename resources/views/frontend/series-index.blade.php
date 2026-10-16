@extends('layouts.app')

@section('title', 'Daftar Master Series - Pancasuman')

@section('content')
<div class="space-y-8">
    
    {{-- Header Banner Series --}}
    <div class="bg-gradient-to-br from-purple-950 via-slate-900 to-indigo-950 text-white rounded-3xl p-8 sm:p-12 shadow-xl border border-purple-900/40 relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-2xl space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-purple-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Karya Bersambung</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black font-serif tracking-tight text-white">Master Series & Cerpen Bersambung</h1>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                Jelajahi kumpulan seri tulisan tematik, novel bersambung, dan esai bertahap yang dikurasi khusus oleh penulis Pancasuman.
            </p>
        </div>
    </div>

    {{-- Grid Series --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($seriesList as $series)
        <div class="card-lift bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:border-purple-300 dark:hover:border-purple-500/50 rounded-3xl overflow-hidden shadow-xs flex flex-col justify-between group transition-all duration-300">
            @if($series->cover_image)
            <div class="h-48 w-full overflow-hidden bg-purple-950/5 dark:bg-purple-950/20">
                <img src="{{ asset('storage/' . $series->cover_image) }}" alt="{{ $series->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            @endif
            <div class="p-7 flex flex-col justify-between flex-1">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="badge-series text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $series->category->name ?? 'Umum' }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition mb-3 leading-snug">
                        <a href="{{ route('series.show', $series->slug) }}">
                            {{ $series->title }}
                        </a>
                    </h3>
                    
                    <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 leading-relaxed mb-6">
                        {{ $series->description ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>
                
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-bold flex items-center justify-center text-[10px]">
                            {{ substr($series->author->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="font-medium text-slate-700 dark:text-slate-300 truncate max-w-[120px]">{{ $series->author->name ?? 'Anonim' }}</span>
                    </div>
                    <a href="{{ route('series.show', $series->slug) }}" class="inline-flex items-center gap-1 text-purple-700 dark:text-purple-400 font-semibold group-hover:translate-x-0.5 transition-transform">
                        <span>Buka Bab</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 space-y-3">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-sm">Belum ada Master Series yang tersedia saat ini.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $seriesList->links() }}
    </div>
</div>
@endsection