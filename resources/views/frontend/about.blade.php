@extends('layouts.app')

@section('title', 'Tentang Kami - Pancasuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    
    {{-- Header --}}
    <div class="text-center pb-6 space-y-3">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full badge-primary text-xs font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Mengenal Lebih Dekat</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 font-serif tracking-tight">Tentang Pancasuman</h1>
        <p class="text-slate-500 text-sm sm:text-base leading-relaxed max-w-xl mx-auto">Ruang kolaborasi dan literasi untuk para pemikir, penikmat sastra, dan jamaah Maiyah.</p>
    </div>

    {{-- 3 Nilai Pokok / Value Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-2">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                01
            </div>
            <h3 class="font-bold text-slate-900 text-base">Literasi Bermartabat</h3>
            <p class="text-slate-500 text-xs leading-relaxed">Menyediakan ruang sehat untuk bertukar ide, memperdalam wawasan, dan memperhalus budi pekerti.</p>
        </div>
        
        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-2">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                02
            </div>
            <h3 class="font-bold text-slate-900 text-base">Semangat Maiyah</h3>
            <p class="text-slate-500 text-xs leading-relaxed">Terinspirasi dari keteduhan, kebijaksanaan, dan kehangatan lingkaran silaturahmi jamaah.</p>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-2">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold">
                03
            </div>
            <h3 class="font-bold text-slate-900 text-base">Kreativitas Terbuka</h3>
            <p class="text-slate-500 text-xs leading-relaxed">Wadah bagi karya esai reflektif, cerpen bersambung, dan tulisan kontemplatif para kontributor.</p>
        </div>
    </div>

    {{-- Konten Teks Utama (Dinamis dari Database) --}}
    <article class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-12 shadow-sm prose-editorial max-w-none text-slate-800 leading-relaxed font-sans">
        @if($page && $page->content)
            {!! nl2br(e($page->content)) !!}
        @else
            <div class="text-center py-10 space-y-2">
                <p class="text-slate-400 italic text-sm">Konten tentang kami belum diatur melalui Master Pages di panel developer.</p>
            </div>
        @endif
    </article>

    {{-- Tombol Navigasi Bawah --}}
    <div class="pt-2 flex items-center justify-between text-sm">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 font-semibold text-slate-600 hover:text-blue-600 group transition-colors">
            <span class="group-hover:-translate-x-1 transition-transform">&larr;</span>
            <span>Kembali ke Beranda</span>
        </a>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-1 font-semibold text-blue-600 hover:underline">
            <span>Hubungi Redaksi</span>
            <span>&rarr;</span>
        </a>
    </div>

</div>
@endsection