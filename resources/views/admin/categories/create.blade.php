@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('header', 'Tambah Kategori')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Status <span class="text-red-500">*</span></label>
            <select name="status" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Note: Admin tidak perlu input slug sesuai aturan SRS -->
        <p class="text-xs text-gray-500 mb-6 italic">* Slug akan dibuat secara otomatis oleh sistem.</p>

        {{-- Pengaturan SEO & Meta Tags --}}
<div class="my-6 bg-slate-50 p-5 rounded-xl border border-slate-200">
    <h3 class="text-sm font-bold text-slate-800 mb-3 uppercase tracking-wider">Pengaturan SEO (Opsional)</h3>
    
    <div class="mb-4">
        <label class="block text-slate-700 text-xs font-bold mb-1">Meta Title (Judul untuk Google/Sosmed)</label>
        <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}" class="w-full border border-slate-300 p-2.5 rounded-lg text-sm bg-white focus:outline-none focus:border-blue-500" placeholder="Kosongkan jika ingin sama dengan judul utama">
        @error('meta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-slate-700 text-xs font-bold mb-1">Meta Description (Ringkasan SEO - Maks 160 karakter)</label>
        <textarea name="meta_description" rows="2" class="w-full border border-slate-300 p-2.5 rounded-lg text-sm bg-white focus:outline-none focus:border-blue-500" placeholder="Tulis deskripsi singkat yang menarik perhatian pembaca di hasil pencarian...">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
        @error('meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:underline">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection