@extends('layouts.admin')

@section('title', 'Edit Link Video - Admin')
@section('header', 'Edit Link Video')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Edit Tautan Video</h2>
            <p class="text-xs text-slate-500 mt-1">Perbarui judul, tautan, atau thumbnail kustom video.</p>
        </div>
        <a href="{{ route('admin.videos.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        {{-- Judul Video --}}
        <div class="space-y-1.5">
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Judul Video / Nama Acara <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-900">
            @error('title') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- URL Video --}}
        <div class="space-y-1.5">
            <label for="video_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Tautan Video (URL) <span class="text-rose-500">*</span>
            </label>
            <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $video->video_url) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-900">
            @error('video_url') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Thumbnail Saat Ini & Ganti Baru --}}
        <div class="space-y-2">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Thumbnail Video
            </label>
            @if($video->thumbnail)
                @php
                    $thumbSrc = str_starts_with($video->thumbnail, 'http') ? $video->thumbnail : asset('storage/' . $video->thumbnail);
                @endphp
                <div class="w-48 h-28 rounded-xl overflow-hidden border border-slate-200 bg-slate-100">
                    <img src="{{ $thumbSrc }}" alt="Thumbnail" class="w-full h-full object-cover">
                </div>
            @endif
            <input type="file" name="thumbnail" id="thumbnail" accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer cursor-pointer border border-slate-200 rounded-xl p-2 bg-slate-50/50">
            <p class="text-[11px] text-slate-400">Kosongkan jika tidak ingin mengubah thumbnail.</p>
            @error('thumbnail') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi Singkat Video --}}
        <div class="space-y-1.5">
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Deskripsi Singkat (Opsional)
            </label>
            <textarea name="description" id="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-900">{{ old('description', $video->description) }}</textarea>
            @error('description') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.videos.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                Simpan Perubahan Video
            </button>
        </div>
    </form>
</div>
@endsection
