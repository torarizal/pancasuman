@extends('layouts.app')

@section('title', 'Kontak Redaksi - Pancasuman')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    {{-- Header --}}
    <div class="text-center border-b border-slate-200 pb-8">
        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full mb-4 inline-block">Pusat Layanan & Kolaborasi</span>
        <h1 class="text-4xl font-black text-slate-900 mt-2 mb-4">Hubungi Redaksi</h1>
        <p class="text-lg text-slate-500">Punya pertanyaan, kritik, atau tawaran kerja sama? Kami selalu terbuka untuk mendengarkan.</p>
    </div>

    {{-- Kartu Utama Informasi Kontak (Dinamis dari Database) --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-8 sm:p-12 shadow-sm relative overflow-hidden">
        {{-- Aksen Dekorasi Tipis di Sudut --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -z-0 opacity-50 pointer-events-none"></div>

        <div class="relative z-10 prose prose-slate max-w-none text-slate-700 leading-relaxed text-base sm:text-lg">
            @if($page && $page->content)
                {!! nl2br(e($page->content)) !!}
            @else
                <p class="text-slate-400 italic">Informasi kontak belum diatur melalui Master Pages di panel developer.</p>
            @endif
        </div>
    </div>

    {{-- Tombol Kembali --}}
    {{-- <div class="text-center pt-4">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:underline">
            &larr; Kembali ke Beranda
        </a>
    </div> --}}
</div>
@endsection