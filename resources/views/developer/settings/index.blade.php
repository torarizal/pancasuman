@extends('layouts.developer')

@section('title', 'Pengaturan Logo & Branding Web - Developer')
@section('header', 'Identitas Website & Upload Logo')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div>
        <h2 class="text-xl font-bold text-white tracking-tight">Kustomisasi Logo & Identitas Visual</h2>
        <p class="text-xs text-slate-400 mt-1">Unggah logo resmi komunitas/portal yang akan ditampilkan pada header navigasi publik, footer, dan bilah samping dashboard.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kartu Status Logo Saat Ini --}}
        <div class="lg:col-span-1 bg-slate-950/70 border border-slate-800 rounded-2xl p-6 shadow-xl flex flex-col justify-between space-y-6">
            <div>
                <h3 class="text-xs font-mono uppercase text-slate-400 font-bold mb-3">Status Logo Saat Ini</h3>
                
                {{-- Preview Box pada Latar Terang & Gelap --}}
                <div class="space-y-3">
                    <p class="text-[11px] text-slate-500 font-mono">Tampilan pada latar terang (Navbar Publik):</p>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-2.5 min-h-[90px]">
                        @if($siteLogo)
                            <div class="w-10 h-10 rounded-xl overflow-hidden flex items-center justify-center bg-white shadow-xs border border-slate-200/80 shrink-0">
                                <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo Pancasuman" class="w-full h-full object-contain p-0.5">
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white text-xs font-bold shrink-0">P</div>
                        @endif
                        <div class="flex flex-col">
                            <span class="font-extrabold text-sm text-slate-800 leading-tight">PANCASUMAN</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Portal Literasi</span>
                        </div>
                    </div>

                    <p class="text-[11px] text-slate-500 font-mono">Tampilan pada latar gelap (Dev Console):</p>
                    <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 flex items-center gap-2.5 min-h-[90px]">
                        @if($siteLogo)
                            <div class="w-9 h-9 rounded-xl overflow-hidden flex items-center justify-center bg-slate-900 shadow-xs border border-slate-800 shrink-0">
                                <img src="{{ asset('storage/' . $siteLogo) }}" alt="Logo Pancasuman" class="w-full h-full object-contain p-0.5">
                            </div>
                        @else
                            <div class="w-9 h-9 rounded-xl bg-purple-600 flex items-center justify-center text-white text-xs font-bold shrink-0">P</div>
                        @endif
                        <div class="flex flex-col">
                            <span class="font-extrabold text-sm text-white leading-tight">PANCASUMAN</span>
                            <span class="text-[10px] uppercase font-mono text-purple-400 tracking-widest">DEV CONSOLE</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($siteLogo)
                <form action="{{ route('admin.developer.settings.logo.destroy') }}" method="POST" onsubmit="return confirm('Hapus logo saat ini dan kembali ke logo teks bawaan?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-rose-950/60 hover:bg-rose-900 text-rose-300 hover:text-white border border-rose-800/60 text-xs font-semibold transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Hapus Logo (Gunakan Teks)</span>
                    </button>
                </form>
            @endif
        </div>

        {{-- Form Unggah Logo Baru --}}
        <div class="lg:col-span-2 bg-slate-950/70 border border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xl space-y-6">
            <div>
                <h3 class="text-base font-bold text-white">Unggah Berkas Logo Baru</h3>
                <p class="text-xs text-slate-400 mt-0.5">Disarankan menggunakan gambar berlatar transparan (format PNG, WebP, atau SVG).</p>
            </div>

            <form action="{{ route('admin.developer.settings.logo.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label for="logo-input" class="block text-xs font-mono uppercase text-slate-300">Pilih Berkas Logo</label>
                    <input type="file" name="logo" id="logo-input" accept="image/png,image/jpeg,image/webp,image/svg+xml" required class="w-full text-xs text-slate-400 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-600 file:text-white hover:file:bg-purple-500 file:cursor-pointer cursor-pointer border border-slate-800 rounded-xl p-2 bg-slate-900">
                    @error('logo') <p class="text-rose-400 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Live Preview Box Baru --}}
                <div id="new-logo-preview-wrapper" class="hidden space-y-2 pt-2">
                    <p class="text-xs font-mono uppercase text-slate-400">Pratinjau Berkas Terpilih:</p>
                    <div class="p-4 rounded-xl bg-slate-900 border border-purple-800/60 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl overflow-hidden flex items-center justify-center bg-white shadow-xs border border-slate-700 shrink-0">
                            <img id="new-logo-preview" src="" alt="Pratinjau Logo Baru" class="w-full h-full object-contain p-0.5">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-sm text-white leading-tight">PANCASUMAN</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Portal Literasi</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-purple-950/40 border border-purple-800/40 space-y-2 text-xs text-slate-300">
                    <div class="flex items-center gap-2 text-purple-300 font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Panduan Format Logo:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-slate-400 text-[11px]">
                        <li>Rasio persegi / kotak 1:1 (disarankan: 512x512 px atau minimal 256x256 px).</li>
                        <li>Format terbaik: PNG transparan atau WebP tanpa latar belakang warna.</li>
                        <li>Maksimal ukuran file: 2 MB. Gambar otomatis dikompres untuk kecepatan muat.</li>
                    </ul>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs shadow-lg shadow-purple-600/30 transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span>Simpan & Terapkan Logo</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    document.getElementById('logo-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                const preview = document.getElementById('new-logo-preview');
                const wrapper = document.getElementById('new-logo-preview-wrapper');
                preview.src = evt.target.result;
                wrapper.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
