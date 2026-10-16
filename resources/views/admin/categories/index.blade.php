@extends('layouts.admin')

@section('title', 'Manajemen Kategori Rubrik')
@section('header', 'Manajemen Kategori Rubrik')

@section('content')
<div class="space-y-6">

    {{-- Header & Hak Akses Notice --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">Daftar Rubrik & Kategori</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Kategori utama untuk pengelompokan tulisan artikel, opini, dan karya sastra.</p>
        </div>

        @if(auth()->user()->isDeveloper())
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-bold text-xs shadow-xs transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Kategori Baru</span>
            </a>
        @else
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 text-amber-800 dark:text-amber-300 text-xs font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span>Mode Lihat Saja (Kelola Kategori Khusus Developer)</span>
            </div>
        @endif
    </div>

    {{-- Tabel Kategori --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xs border border-slate-200/90 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider border-b border-slate-200/80 dark:border-slate-800">
                        <th class="p-4">Nama Rubrik</th>
                        <th class="p-4">Slug URL</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/50 transition">
                        <td class="p-4">
                            <span class="font-bold text-slate-900 dark:text-slate-100">{{ $category->name }}</span>
                        </td>
                        <td class="p-4 font-mono text-xs text-blue-600 dark:text-blue-400">
                            /rubrik/{{ $category->slug }}
                        </td>
                        <td class="p-4">
                            @if($category->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>Aktif</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    <span>Tidak Aktif</span>
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            @if(auth()->user()->isDeveloper())
                                <div class="inline-flex items-center gap-3">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-slate-400 dark:text-slate-500 italic">Hanya Lihat</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 dark:text-slate-500 text-xs">Belum ada kategori yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            {{ $categories->links() }}
        </div>
        @endif
    </div>

</div>
@endsection