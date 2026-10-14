@extends('layouts.app')

@section('title', 'Biografi Cak Nun - Pancasuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    
    {{-- Header & Foto Profil --}}
    <div class="text-center pb-8 space-y-6 relative">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200/80 text-amber-800 text-xs font-semibold shadow-xs">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
            <span>Tokoh Literasi & Penggagas Maiyah</span>
        </div>
        
        {{-- Frame Foto Profil --}}
        <div class="relative w-48 h-48 sm:w-56 sm:h-56 mx-auto">
            <div class="w-full h-full rounded-3xl overflow-hidden shadow-xl ring-4 ring-white border border-slate-200/70 bg-gradient-to-tr from-slate-800 to-slate-900 flex items-center justify-center">
                @if($page && $page->image)
                    <img src="{{ asset('storage/' . $page->image) }}" alt="Emha Ainun Nadjib" class="w-full h-full object-cover">
                @else
                    <div class="text-center p-6 text-white space-y-2">
                        <div class="w-16 h-16 mx-auto rounded-full bg-white/10 flex items-center justify-center text-3xl font-serif font-black text-amber-300">
                            CN
                        </div>
                        <span class="text-xs text-slate-300 font-medium block">Emha Ainun Nadjib</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-2 max-w-2xl mx-auto">
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 font-serif tracking-tight">
                Emha Ainun Nadjib (Cak Nun)
            </h1>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed font-sans">
                Budayawan, Intelektual Muslim, Penggagas Gerakan Jamaah Maiyah, dan Penulis Lintas Generasi.
            </p>
        </div>
    </div>

    {{-- Kutipan Hikmah / Wisdom Callout --}}
    <div class="rounded-3xl p-6 sm:p-8 bg-gradient-to-br from-amber-500/10 via-amber-50/50 to-orange-50 border border-amber-200/70 shadow-xs relative overflow-hidden">
        <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-amber-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                </svg>
            </div>
            <div class="space-y-1 text-center sm:text-left">
                <p class="text-base sm:text-lg font-serif italic text-slate-800 leading-relaxed">
                    "Tuhan tidak menuntut kita untuk selalu menang dalam setiap pertandingan, Tuhan hanya meminta kita untuk terus berjuang dengan hati yang tulus dan jujur."
                </p>
                <span class="text-xs font-bold text-amber-900 uppercase tracking-widest block pt-1">
                    — Mutiara Pemikiran Maiyah
                </span>
            </div>
        </div>
    </div>

    {{-- Konten Teks Utama (Dinamis dari Database) --}}
    <article class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-12 shadow-sm prose-editorial max-w-none text-slate-800 leading-relaxed">
        @if($page && $page->content)
            {!! $page->content !!}
        @else
            <div class="text-center py-12 space-y-3">
                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <p class="text-slate-500 font-medium text-sm">Konten biografi sedang dalam proses penyusunan redaksi melalui panel developer.</p>
            </div>
        @endif
    </article>
    
    {{-- Tombol Navigasi Bawah --}}
    <div class="pt-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-blue-600 group transition-colors">
            <span class="group-hover:-translate-x-1 transition-transform">&larr;</span>
            <span>Kembali ke Beranda</span>
        </a>
        <a href="{{ route('archive') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:underline">
            <span>Baca Karya Komunitas</span>
            <span>&rarr;</span>
        </a>
    </div>

</div>
@endsection