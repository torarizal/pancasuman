@extends('layouts.app')

@section('title', 'Kontak Redaksi - Pancasuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    
    {{-- Header --}}
    <div class="text-center pb-4 space-y-3">
        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full badge-primary text-xs font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span>Pusat Layanan & Silaturahmi</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-slate-100 font-serif tracking-tight">Hubungi Redaksi</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base leading-relaxed max-w-xl mx-auto">Punya saran naskah, kritik, tawaran kerja sama, atau ingin berkontribusi? Pintu kami selalu terbuka.</p>
    </div>

    {{-- Channel Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-xs space-y-2">
            <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <h3 class="font-bold text-slate-900 dark:text-slate-100 text-base">Kirim Tulisan</h3>
            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">Terbuka untuk esai, cerpen, opini budaya, dan resensi buku karya jamaah.</p>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-xs space-y-2">
            <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="font-bold text-slate-900 dark:text-slate-100 text-base">Kolaborasi Komunitas</h3>
            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">Kerja sama majelis literasi, diskusi buku, dan publikasi kegiatan Maiyah.</p>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-xs space-y-2">
            <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <h3 class="font-bold text-slate-900 dark:text-slate-100 text-base">Kritik & Masukan</h3>
            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">Bantuan perbaikan, koreksi redaksional, dan saran pengembangan portal.</p>
        </div>
    </div>

    {{-- Kartu Utama Informasi Kontak (Dinamis dari Database) --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-12 shadow-sm relative overflow-hidden">
        {{-- Aksen Dekorasi Tipis di Sudut --}}
        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-bl from-blue-100/60 dark:from-blue-900/20 to-transparent rounded-bl-full pointer-events-none"></div>

        <div class="relative z-10 prose-editorial max-w-none text-slate-700 dark:text-slate-300 leading-relaxed font-sans">
            @if($page && $page->content)
                {!! nl2br(e($page->content)) !!}
            @else
                <div class="text-center py-8">
                    <p class="text-slate-400 dark:text-slate-500 italic text-sm">Informasi kontak belum diatur melalui Master Pages di panel developer.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="pt-2">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 group transition-colors">
            <span class="group-hover:-translate-x-1 transition-transform">&larr;</span>
            <span>Kembali ke Beranda</span>
        </a>
    </div>

</div>
@endsection