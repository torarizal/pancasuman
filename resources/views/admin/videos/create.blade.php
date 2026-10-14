@extends('layouts.admin')

@section('title', 'Tambah Link Video - Admin')
@section('header', 'Tambah Link Video')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Tambah Tautan Video Baru</h2>
            <p class="text-xs text-slate-500 mt-1">Cukup tempelkan tautan video YouTube atau postingan media sosial.</p>
        </div>
        <a href="{{ route('admin.videos.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-xs space-y-6">
        @csrf

        {{-- Judul Video --}}
        <div class="space-y-1.5">
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Judul Video / Nama Acara <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: Sinau Bareng Cak Nun & KiaiKanjeng di Surabaya" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-900">
            @error('title') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- URL Video --}}
        <div class="space-y-1.5">
            <label for="video_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Tautan Video (URL) <span class="text-rose-500">*</span>
            </label>
            <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}" required placeholder="Contoh: https://www.youtube.com/watch?v=xxxx atau https://youtu.be/xxxx" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-900">
            <p class="text-[11px] text-slate-400">Mendukung link YouTube, YouTube Shorts, Instagram Reels, TikTok, dan Facebook.</p>
            @error('video_url') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Thumbnail Kustom (Opsional) --}}
        <div class="space-y-1.5">
            <label for="thumbnail" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Gambar Thumbnail Kustom (Opsional)
            </label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer cursor-pointer border border-slate-200 rounded-xl p-2 bg-slate-50/50">
            <p class="text-[11px] text-slate-400">Jika menggunakan link YouTube, gambar sampul video akan otomatis diambil tanpa perlu upload lagi.</p>
            @error('thumbnail') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi Singkat Video --}}
        <div class="space-y-1.5">
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Deskripsi Singkat (Opsional)
            </label>
            <textarea name="description" id="description" rows="3" placeholder="Tuliskan catatan singkat tentang video ini..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-900">{{ old('description') }}</textarea>
            @error('description') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.videos.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                Simpan Link Video
            </button>
        </div>
    </form>
</div>
@endsection
