@extends('layouts.developer')

@section('title', 'Master Halaman Statis - Developer')
@section('header', 'Master Halaman Statis')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Kelola Konten Halaman Statis</h2>
            <p class="text-xs text-slate-400 mt-1">Halaman-halaman khusus yang terintegrasi langsung dengan menu navigasi utama website.</p>
        </div>
    </div>

    <div class="bg-slate-950/70 rounded-2xl shadow-xl border border-slate-800 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-900 border-b border-slate-800 text-slate-400 text-xs font-mono uppercase tracking-wider">
                <tr>
                    <th class="p-4">Nama Halaman</th>
                    <th class="p-4">Slug Route</th>
                    <th class="p-4 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @foreach($pages as $page)
                <tr class="hover:bg-slate-900/40 transition">
                    <td class="p-4">
                        <div class="font-bold text-white">{{ $page->title }}</div>
                        <div class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ Str::limit(strip_tags($page->content), 80) }}</div>
                    </td>
                    <td class="p-4 font-mono text-xs text-purple-400">
                        /{{ $page->slug }}
                    </td>
                    <td class="p-4 text-center">
                        <a href="{{ route('admin.developer.pages.edit', $page->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-purple-600 hover:bg-purple-500 text-white font-semibold text-xs transition shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit Konten</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection