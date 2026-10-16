@extends('layouts.admin')

@section('title', 'Galeri Kegiatan - Admin')
@section('header', 'Galeri Foto Kegiatan')

@section('content')
<div class="space-y-6">

    {{-- Header & Action Button --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">Dokumentasi Foto Kegiatan</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Himpunan arsip foto dokumentasi acara, majelis, dan aktivitas komunitas.</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Foto Kegiatan</span>
        </a>
    </div>

    {{-- Grid Foto Galeri --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($galleries as $item)
        <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition group flex flex-col justify-between">
            <div>
                <div class="h-44 w-full bg-slate-100 dark:bg-slate-800 overflow-hidden relative">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @if($item->activity_date)
                        <span class="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-mono">
                            {{ $item->activity_date->format('d M Y') }}
                        </span>
                    @endif
                </div>

                <div class="p-4 space-y-1.5">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-slate-100 line-clamp-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                        {{ $item->title }}
                    </h3>
                    @if($item->description)
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2">{{ $item->description }}</p>
                    @endif
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 font-mono pt-1">
                        Oleh: {{ $item->user->name ?? 'Admin' }}
                    </p>
                </div>
            </div>

            <div class="px-4 py-3 bg-slate-50/70 dark:bg-slate-800/60 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                <a href="{{ route('admin.galleries.edit', $item->id) }}" class="font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition">
                    Edit Data
                </a>
                <form action="{{ route('admin.galleries.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus foto kegiatan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="font-semibold text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 transition cursor-pointer">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-12 text-center text-slate-400 dark:text-slate-500 text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p>Belum ada foto kegiatan di galeri. Klik tombol "Tambah Foto Kegiatan" untuk mengunggah.</p>
        </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
    <div class="pt-4">
        {{ $galleries->links() }}
    </div>
    @endif

</div>
@endsection
