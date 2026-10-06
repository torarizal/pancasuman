@extends('layouts.app')

@section('title', 'Tentang Kami - Pancasuman')

@section('content')
<div class="max-w-4xl mx-auto space-y-12">
    {{-- Header --}}
    <div class="text-center border-b border-slate-200 pb-8">
        <h1 class="text-4xl font-black text-slate-900 mb-4">Tentang Pancasuman</h1>
        <p class="text-lg text-slate-500">Ruang kolaborasi dan literasi untuk para penulis dan pemikir.</p>
    </div>

   

    {{-- Konten Teks Utama (Dinamis dari Database) --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-8 sm:p-12 shadow-sm prose prose-slate max-w-none text-slate-800 leading-relaxed text-base sm:text-lg">
        @if($page && $page->content)
            {!! nl2br(e($page->content)) !!}
        @else
            <p class="text-slate-400 italic">Konten tentang kami belum diatur melalui Master Pages di panel developer.</p>
        @endif
    </div>
</div>
@endsection