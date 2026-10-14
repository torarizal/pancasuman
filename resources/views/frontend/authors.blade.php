@extends('layouts.app')

@section('title', 'Direktori Penulis - Pancasuman')

@section('content')
<div class="space-y-10">
    
    {{-- Header Direktori Penulis --}}
    <div class="text-center max-w-xl mx-auto space-y-2">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full badge-primary text-xs font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>Para Penggubah Kata</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 font-serif tracking-tight">Direktori Penulis</h1>
        <p class="text-slate-500 text-sm leading-relaxed">Mengenal lebih dekat para kontributor dan karya-karya bermakna mereka.</p>
    </div>

    {{-- Grid Kartu Penulis --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @forelse($authors as $author)
        <a href="{{ route('authors.show', $author->id) }}" class="card-lift bg-white border border-slate-200/80 hover:border-blue-300 rounded-3xl p-6 text-center shadow-xs group flex flex-col items-center justify-between transition-all duration-300">
            <div class="w-18 h-18 bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 text-white rounded-2xl flex items-center justify-center text-2xl font-black mb-4 shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform duration-300">
                {{ substr($author->name, 0, 1) }}
            </div>
            <div class="space-y-1 w-full">
                <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition truncate">{{ $author->name }}</h3>
                <span class="inline-block text-[11px] font-semibold text-slate-500 bg-slate-100/80 px-2.5 py-0.5 rounded-full">
                    {{ $author->posts_count }} Karya
                </span>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-3xl border border-dashed border-slate-200 space-y-3">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <p class="text-slate-500 font-medium text-sm">Belum ada penulis yang mempublikasikan karya.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $authors->links() }}
    </div>
</div>
@endsection