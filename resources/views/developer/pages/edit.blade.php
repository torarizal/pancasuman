@extends('layouts.app')

@section('content')
{{-- Summernote CSS Lite --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">

<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-slate-900 mb-6">Edit Halaman: {{ $page->title }}</h1>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.developer.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Judul Halaman (Readonly)</label>
                <input type="text" value="{{ $page->title }}" disabled class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-slate-500 cursor-not-allowed">
            </div>

            {{-- Input Upload Foto --}}
            @if($page->slug == 'biografi-cak-nun' || $page->slug == 'tentang-kami')
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        {{ $page->slug == 'biografi-cak-nun' ? 'Foto Profil Tokoh (Cak Nun)' : 'Foto Utama / Banner Halaman' }}
                    </label>
                    
                    @if($page->image)
                        <div class="mb-3 flex items-center gap-4">
                            <img src="{{ asset('storage/' . $page->image) }}" alt="Current Image" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shadow-sm">
                            <span class="text-xs text-slate-500">Foto saat ini terpasang. Upload foto baru di bawah jika ingin menggantinya.</span>
                        </div>
                    @endif

                    <input type="file" name="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-slate-300 rounded-lg">
                </div>
            @endif

            {{-- Textarea dengan ID untuk Summernote --}}
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Konten Teks Utama</label>
                <textarea id="summernote" name="content" rows="10" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 leading-relaxed" required>{{ old('content', $page->content) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.developer.pages.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 transition text-sm font-medium">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition text-sm shadow-sm">Simpan Perubahan</button>
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
                ['font', ['bold', 'underline', 'clear']],
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