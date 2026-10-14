@extends('layouts.admin')

@section('title', 'Edit Foto Kegiatan - Admin')
@section('header', 'Edit Foto Kegiatan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Edit Data Dokumentasi</h2>
            <p class="text-xs text-slate-500 mt-1">Perbarui nama kegiatan, foto, atau tanggal pelaksanaan.</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        {{-- Nama Kegiatan --}}
        <div class="space-y-1.5">
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Nama Kegiatan <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-900">
            @error('title') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Tanggal Kegiatan --}}
        <div class="space-y-1.5">
            <label for="activity_date" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Tanggal Pelaksanaan (Opsional)
            </label>
            <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date', optional($gallery->activity_date)->format('Y-m-d')) }}" class="w-full sm:w-64 px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-900">
            @error('activity_date') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Foto Kegiatan Saat Ini & Ganti Baru --}}
        <div class="space-y-3">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Foto Kegiatan
            </label>
            
            <div class="w-full h-48 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 relative">
                <img id="current-image" src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
            </div>

            <input type="file" name="image" id="image-input" accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer cursor-pointer border border-slate-200 rounded-xl p-2 bg-slate-50/50">
            <p class="text-[11px] text-slate-400">Kosongkan jika tidak ingin mengganti foto saat ini.</p>
            @error('image') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Deskripsi Singkat Kegiatan --}}
        <div class="space-y-1.5">
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                Keterangan / Deskripsi Singkat (Opsional)
            </label>
            <textarea name="description" id="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-900">{{ old('description', $gallery->description) }}</textarea>
            @error('description') <p class="text-rose-600 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.galleries.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition cursor-pointer">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('image-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                document.getElementById('current-image').src = evt.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
