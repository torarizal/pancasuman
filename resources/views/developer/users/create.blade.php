@extends('layouts.developer')

@section('title', 'Tambah Pengguna Baru - Developer')
@section('header', 'Tambah Akun Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Buat Kredensial Akun Baru</h2>
            <p class="text-xs text-slate-400 mt-1">Daftarkan akun pengelola atau penulis dengan hak akses peran tertentu.</p>
        </div>
        <a href="{{ route('admin.developer.users.index') }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('admin.developer.users.store') }}" method="POST" class="bg-slate-950/70 border border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
        @csrf

        {{-- Nama Lengkap --}}
        <div class="space-y-1.5">
            <label for="name" class="block text-xs font-mono uppercase text-slate-300">
                Nama Lengkap <span class="text-rose-400">*</span>
            </label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: Ahmad Baihaqi" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-sm text-white focus:outline-none focus:border-purple-500">
            @error('name') <p class="text-rose-400 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div class="space-y-1.5">
            <label for="email" class="block text-xs font-mono uppercase text-slate-300">
                Alamat Email <span class="text-rose-400">*</span>
            </label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="Contoh: ahmad@pancasuman.com" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-sm text-white focus:outline-none focus:border-purple-500">
            @error('email') <p class="text-rose-400 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div class="space-y-1.5">
            <label for="password" class="block text-xs font-mono uppercase text-slate-300">
                Kata Sandi (Password) <span class="text-rose-400">*</span>
            </label>
            <input type="password" name="password" id="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-sm text-white focus:outline-none focus:border-purple-500">
            @error('password') <p class="text-rose-400 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Role / Hak Akses --}}
        <div class="space-y-1.5">
            <label for="role" class="block text-xs font-mono uppercase text-slate-300">
                Peran / Hak Akses (Role) <span class="text-rose-400">*</span>
            </label>
            <select name="role" id="role" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-sm text-white focus:outline-none focus:border-purple-500">
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Mengelola artikel, series, galeri kegiatan, dan video)</option>
                <option value="developer" {{ old('role') == 'developer' ? 'selected' : '' }}>Developer (Akses penuh: kelola akun, kategori, logo, dan sistem)</option>
            </select>
            @error('role') <p class="text-rose-400 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- Biodata Singkat --}}
        <div class="space-y-1.5">
            <label for="bio" class="block text-xs font-mono uppercase text-slate-300">
                Biodata Singkat (Opsional)
            </label>
            <textarea name="bio" id="bio" rows="3" placeholder="Informasi latar belakang penulis untuk ditampilkan di direktori publik..." class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-sm text-white focus:outline-none focus:border-purple-500">{{ old('bio') }}</textarea>
            @error('bio') <p class="text-rose-400 text-xs">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
            <a href="{{ route('admin.developer.users.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs shadow-lg shadow-purple-600/30 transition cursor-pointer">
                Simpan & Daftarkan Akun
            </button>
        </div>
    </form>
</div>
@endsection
