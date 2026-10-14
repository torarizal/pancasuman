@extends('layouts.developer')

@section('title', 'Edit Halaman: ' . $page->title . ' - Developer')
@section('header', 'Edit Halaman Statis')

@section('content')
{{-- Summernote CSS Lite --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">

<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Edit Halaman: {{ $page->title }}</h2>
            <p class="text-xs text-slate-400 mt-1">Perubahan akan langsung tampil pada rute publik: <code class="font-mono text-purple-400">/{{ $page->slug }}</code></p>
        </div>
        <a href="{{ route('admin.developer.pages.index') }}" class="text-xs text-slate-400 hover:text-white transition flex items-center gap-1 font-mono">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <div class="bg-slate-950/80 rounded-2xl shadow-xl border border-slate-800 p-6 sm:p-8">
        <form action="{{ route('admin.developer.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-mono uppercase tracking-wider text-slate-400 mb-2">Judul Halaman (Sistem Readonly)</label>
                <input type="text" value="{{ $page->title }}" disabled class="w-full rounded-xl border border-slate-800 bg-slate-900 px-4 py-2.5 text-slate-400 font-semibold cursor-not-allowed">
            </div>

            {{-- Input Upload Foto --}}
            @if($page->slug == 'biografi-cak-nun' || $page->slug == 'tentang-kami')
                <div class="p-4 rounded-xl bg-slate-900 border border-slate-800">
                    <label class="block text-xs font-mono uppercase tracking-wider text-slate-300 mb-2">
                        {{ $page->slug == 'biografi-cak-nun' ? 'Foto Profil Tokoh (Cak Nun)' : 'Foto Utama / Banner Halaman' }}
                    </label>
                    
                    @if($page->image)
                        <div class="mb-3 flex items-center gap-4">
                            <img src="{{ asset('storage/' . $page->image) }}" alt="Current Image" loading="lazy" decoding="async" class="w-20 h-20 object-cover rounded-xl border border-slate-700 shadow-sm">
                            <span class="text-xs text-slate-400">Foto saat ini terpasang. Unggah foto baru di bawah jika ingin menggantinya.</span>
                        </div>
                    @endif

                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-500 cursor-pointer border border-slate-700 rounded-lg bg-slate-950">
                    <p class="text-[11px] text-slate-500 mt-1">Maksimal ukuran file 2MB (JPG, PNG, WEBP).</p>
                </div>
            @endif

            {{-- Textarea dengan ID untuk Summernote --}}
            <div>
                <label class="block text-xs font-mono uppercase tracking-wider text-slate-300 mb-2">Konten Teks Utama (HTML / Rich Text)</label>
                <div class="bg-white rounded-xl overflow-hidden text-slate-900">
                    <textarea id="summernote" name="content" rows="10" required>{{ old('content', $page->content) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-800">
                <a href="{{ route('admin.developer.pages.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-700 text-slate-400 hover:text-white hover:border-slate-500 transition text-xs font-semibold">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold transition text-xs shadow-md shadow-purple-600/20">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- jQuery & Summernote JS Lite --}}
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Tulis konten halaman di sini...',
            tabsize: 2,
            height: 350,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['codeview', 'help']]
            ]
        });
    });
</script>
@endsection