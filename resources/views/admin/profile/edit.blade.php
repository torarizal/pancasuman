@extends('layouts.admin')

@section('title', 'Ubah Profil Akun - Pancasuman')
@section('header', 'Pengaturan Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb / Header Subtitle --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-slate-900 dark:text-slate-100 tracking-tight">Profil & Keamanan Akun</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola informasi nama, kontak, foto profil, dan kata sandi masuk Anda.</p>
        </div>
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-blue-600 dark:bg-blue-400"></span>
            <span>Role: {{ strtoupper($user->role) }}</span>
        </div>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Kartu Data Pribadi & Avatar --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xs space-y-6">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Informasi Pribadi</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Data ini ditampilkan sebagai nama penulis pada artikel dan portal.</p>
            </div>

            {{-- Avatar & Preview --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="relative group">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 border-2 border-slate-200/80 dark:border-slate-700 shadow-xs flex items-center justify-center shrink-0">
                        @if($user->avatar)
                            <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <img id="avatar-preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                            <div id="avatar-placeholder" class="w-full h-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-black text-3xl flex items-center justify-center">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-2 flex-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Foto Profil (Avatar)</label>
                    <input type="file" name="avatar" id="avatar-input" accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 dark:file:bg-blue-950/60 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/60 file:cursor-pointer cursor-pointer border border-slate-200 dark:border-slate-700 rounded-xl p-1 bg-slate-50/50 dark:bg-slate-800/50">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500">Format: JPG, PNG, WEBP. Maksimal 2MB. Otomatis dikompres & dipotong proporsional.</p>
                    @error('avatar') <p class="text-rose-600 dark:text-rose-400 text-xs">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                {{-- Nama Lengkap --}}
                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-slate-900 dark:text-slate-100 bg-white dark:bg-slate-800">
                    @error('name') <p class="text-rose-600 dark:text-rose-400 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Alamat Email --}}
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-slate-900 dark:text-slate-100 bg-white dark:bg-slate-800">
                    @error('email') <p class="text-rose-600 dark:text-rose-400 text-xs">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Bio / Tentang Penulis --}}
            <div class="space-y-1.5">
                <label for="bio" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    Biodata Singkat Penulis (Opsional)
                </label>
                <textarea name="bio" id="bio" rows="3" placeholder="Tuliskan latar belakang atau kata pengantar singkat tentang Anda..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-slate-900 dark:text-slate-100 bg-white dark:bg-slate-800">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-[11px] text-slate-400 dark:text-slate-500">Deskripsi ini akan tampil di laman profil direktori penulis pada portal publik.</p>
                @error('bio') <p class="text-rose-600 dark:text-rose-400 text-xs">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Kartu Keamanan & Ubah Password --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xs space-y-6">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                <h3 class="text-base font-bold text-slate-900 dark:text-slate-100">Ubah Kata Sandi (Password)</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">Biarkan kosong jika Anda tidak berencana mengganti kata sandi akun saat ini.</p>
            </div>

            <div class="space-y-4">
                {{-- Password Saat Ini --}}
                <div class="space-y-1.5">
                    <label for="current_password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Kata Sandi Saat Ini
                    </label>
                    <input type="password" name="current_password" id="current_password" autocomplete="current-password" placeholder="Masukkan kata sandi lama Anda" class="w-full max-w-md px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-slate-900 dark:text-slate-100 bg-white dark:bg-slate-800">
                    @error('current_password') <p class="text-rose-600 dark:text-rose-400 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl pt-2">
                    {{-- Password Baru --}}
                    <div class="space-y-1.5">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Kata Sandi Baru
                        </label>
                        <input type="password" name="password" id="password" autocomplete="new-password" placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-slate-900 dark:text-slate-100 bg-white dark:bg-slate-800">
                        @error('password') <p class="text-rose-600 dark:text-rose-400 text-xs">{{ $message }}</p> @enderror
                    </div>

                    {{-- Konfirmasi Password Baru --}}
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Ulangi Kata Sandi Baru
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" placeholder="Konfirmasi kata sandi baru" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-slate-900 dark:text-slate-100 bg-white dark:bg-slate-800">
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs hover:shadow-md transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Simpan Perubahan Profil</span>
            </button>
        </div>
    </form>
</div>

{{-- Script Live Preview Avatar --}}
<script>
    document.getElementById('avatar-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                const preview = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');
                preview.src = evt.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
