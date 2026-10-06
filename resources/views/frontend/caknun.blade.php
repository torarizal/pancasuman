@extends('layouts.app')

@section('title', 'Biografi Cak Nun - Pancasuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    {{-- Header & Foto Profil Dinamis dari Database --}}
    <div class="text-center border-b border-slate-200 pb-8 space-y-6">
        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full inline-block">Tokoh Literasi & Budaya</span>
        
        {{-- Frame Foto (Tampil foto hasil upload developer, atau fallback ke default jika belum ada) --}}
        <div class="w-48 h-48 sm:w-56 sm:h-56 mx-auto rounded-2xl overflow-hidden shadow-md border-4 border-white bg-slate-100">
            @if($page && $page->image)
    <div class="w-48 h-48 sm:w-56 sm:h-56 mx-auto rounded-2xl overflow-hidden shadow-md border-4 border-white bg-slate-100">
        <img src="{{ asset('storage/' . $page->image) }}" alt="Emha Ainun Nadjib" class="w-full h-full object-cover">
    </div>
@endif
        </div>

        <div>
            <h1 class="text-4xl font-black text-slate-900 mb-2">Emha Ainun Nadjib (Cak Nun)</h1>
            <p class="text-lg text-slate-500">Budayawan, Intelektual Muslim, dan Penggagas Gerakan Maiyah.</p>
        </div>
    </div>

    {{-- Konten Teks Utama (Dinamis dari Database) --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-8 sm:p-12 shadow-sm prose prose-slate max-w-none text-slate-800 leading-relaxed text-base sm:text-lg">
        @if($page && $page->content)
            {!! nl2br(e($page->content)) !!}
        @else
            <p class="text-slate-400 italic">Konten biografi belum diatur melalui Master Pages di panel developer.</p>
        @endif
    </div>
    
    {{-- Tombol Kembali --}}
    <div class="mt-8 pt-4">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:underline">
            &larr; Kembali ke Beranda
        </a>
    </div>
</div>
@endsection