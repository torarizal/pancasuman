@extends('layouts.admin')

@section('title', 'Manajemen Video Kegiatan - Admin')
@section('header', 'Video Dokumentasi & Majelis')

@section('content')
<div class="space-y-6">

    {{-- Header & Action Button --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Dokumentasi Video Portal</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola tautan video dari YouTube, Instagram, TikTok, atau platform medsos lainnya tanpa perlu upload file video berat.</p>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Link Video</span>
        </a>
    </div>

    {{-- Grid Video --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($videos as $video)
        <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition group flex flex-col justify-between">
            <div>
                {{-- Video Thumbnail & Play Button Overlay --}}
                <div class="h-44 w-full bg-slate-900 overflow-hidden relative flex items-center justify-center">
                    @if($video->thumbnail)
                        @php
                            $thumbSrc = str_starts_with($video->thumbnail, 'http') ? $video->thumbnail : asset('storage/' . $video->thumbnail);
                        @endphp
                        <img src="{{ $thumbSrc }}" alt="{{ $video->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90">
                    @else
                        <div class="w-full h-full bg-gradient-to-tr from-slate-900 to-indigo-950 flex items-center justify-center">
                            <span class="text-xs text-slate-400 font-mono">Video Preview</span>
                        </div>
                    @endif

                    {{-- Play Icon --}}
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-12 h-12 rounded-full bg-blue-600/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    {{-- Platform Badge --}}
                    <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-900/80 backdrop-blur-xs text-white">
                        {{ $video->platform }}
                    </span>
                </div>

                <div class="p-4 space-y-1.5">
                    <h3 class="font-bold text-sm text-slate-900 line-clamp-1 group-hover:text-blue-600 transition">
                        {{ $video->title }}
                    </h3>
                    @if($video->description)
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $video->description }}</p>
                    @endif
                    <a href="{{ $video->video_url }}" target="_blank" rel="noopener" class="text-[11px] text-blue-600 hover:underline truncate block pt-1">
                        &nearr; Buka Link Asli
                    </a>
                </div>
            </div>

            <div class="px-4 py-3 bg-slate-50/70 border-t border-slate-100 flex items-center justify-between text-xs">
                <a href="{{ route('admin.videos.edit', $video->id) }}" class="font-semibold text-blue-600 hover:text-blue-800 transition">
                    Edit Link
                </a>
                <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Hapus tautan video ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="font-semibold text-rose-600 hover:text-rose-800 transition cursor-pointer">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white border border-slate-200/90 rounded-2xl p-12 text-center text-slate-400 text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
            </svg>
            <p>Belum ada tautan video. Klik tombol "Tambah Link Video" untuk menambahkan dari YouTube atau media sosial.</p>
        </div>
        @endforelse
    </div>

    @if($videos->hasPages())
    <div class="pt-4">
        {{ $videos->links() }}
    </div>
    @endif

</div>
@endsection
