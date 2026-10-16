@extends('layouts.admin')

@section('title', 'Manajemen Artikel & Cerpen')
@section('header', 'Daftar Artikel & Cerpen')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xs border border-slate-200/90 dark:border-slate-800 p-6 overflow-hidden">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Semua Tulisan / Karya</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola dan tinjau seluruh artikel dan cerpen yang telah diterbitkan maupun masih berstatus draf.</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs sm:text-sm shadow-xs transition shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tulis Artikel / Cerpen Baru</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-xl mb-4 text-xs sm:text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto -mx-6 sm:mx-0">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">
                    <th class="p-3.5 pl-6 sm:pl-4">No</th>
                    <th class="p-3.5">Judul Tulisan</th>
                    <th class="p-3.5">Rubrik / Kategori</th>
                    <th class="p-3.5">Series / Vol</th>
                    <th class="p-3.5">Penulis</th>
                    <th class="p-3.5">Status</th>
                    <th class="p-3.5 pr-6 sm:pr-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($posts as $index => $post)
                <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/50 transition">
                    <td class="p-3.5 pl-6 sm:pl-4 text-slate-400 dark:text-slate-500 text-xs">{{ $posts->firstItem() + $index }}</td>
                    <td class="p-3.5">
                        <div class="flex items-center gap-3">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="" loading="lazy" decoding="async" class="w-10 h-10 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shrink-0 shadow-2xs">
                            @endif
                            <div class="min-w-0">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="font-bold text-slate-900 dark:text-slate-100 hover:text-blue-600 dark:hover:text-blue-400 transition block truncate max-w-xs sm:max-w-sm">
                                    {{ $post->title }}
                                </a>
                                <div class="text-xs text-slate-400 dark:text-slate-500 font-mono truncate max-w-xs">{{ $post->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3.5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-900/40">
                            {{ $post->category->name ?? '-' }}
                        </span>
                    </td>
                    <td class="p-3.5 text-xs text-slate-600 dark:text-slate-300">
                        @if($post->series)
                            <span class="font-semibold text-purple-700 dark:text-purple-400">{{ $post->series->title }}</span>
                            @if($post->volume_number)
                                <span class="bg-purple-100 dark:bg-purple-950/80 text-purple-800 dark:text-purple-300 px-1.5 py-0.5 rounded font-bold ml-1 text-[10px]">Vol. {{ $post->volume_number }}</span>
                            @endif
                        @else
                            <span class="text-slate-400 dark:text-slate-500">Tulisan Lepas</span>
                        @endif
                    </td>
                    <td class="p-3.5 text-slate-600 dark:text-slate-300 text-xs font-medium">{{ $post->author->name ?? 'Anonim' }}</td>
                    <td class="p-3.5">
                        @if($post->status == 'published')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>Published</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                <span>Draft</span>
                            </span>
                        @endif
                    </td>
                    <td class="p-3.5 pr-6 sm:pr-4 text-center">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Edit</span>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus tulisan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 hover:bg-rose-50 dark:hover:bg-rose-950/30 border border-rose-200 dark:border-rose-900/40 transition cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-slate-400 dark:text-slate-500 text-xs sm:text-sm">
                        Belum ada artikel atau cerpen yang ditulis. Silakan klik tombol "Tulis Artikel / Cerpen Baru".
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800">
        {{ $posts->links() }}
    </div>
</div>
@endsection