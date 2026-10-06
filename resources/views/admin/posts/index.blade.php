@extends('layouts.admin')

@section('title', 'Manajemen Artikel & Cerpen')
@section('header', 'Daftar Artikel & Cerpen')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-bold text-slate-800">Semua Tulisan / Karya</h2>
        <a href="{{ route('admin.posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">
            + Tulis Artikel / Cerpen Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600">
                    <th class="p-3">No</th>
                    <th class="p-3">Judul Tulisan</th>
                    <th class="p-3">Rubrik / Kategori</th>
                    <th class="p-3">Series / Vol</th>
                    <th class="p-3">Penulis</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($posts as $index => $post)
                <tr>
                    <td class="p-3 text-slate-500">{{ $posts->firstItem() + $index }}</td>
                    <td class="p-3">
                        <div class="font-semibold text-slate-800">{{ $post->title }}</div>
                        <div class="text-xs text-slate-400 font-mono">{{ $post->slug }}</div>
                    </td>
                    <td class="p-3">
                        <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-medium">
                            {{ $post->category->name ?? '-' }}
                        </span>
                    </td>
                    <td class="p-3 text-xs text-slate-600">
                        @if($post->series)
                            <span class="font-medium text-purple-700">{{ $post->series->title }}</span>
                            @if($post->volume_number)
                                <span class="bg-purple-100 text-purple-800 px-1.5 py-0.5 rounded ml-1 font-semibold">Vol. {{ $post->volume_number }}</span>
                            @endif
                        @else
                            <span class="text-slate-400">Tulisan Lepas</span>
                        @endif
                    </td>
                    <td class="p-3 text-slate-600 text-xs">{{ $post->author->name ?? 'Anonim' }}</td>
                    <td class="p-3">
                        @if($post->status == 'published')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Published</span>
                        @else
                            <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded text-xs font-semibold">Draft</span>
                        @endif
                    </td>
                    <td class="p-3 text-center space-x-2">
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-amber-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus tulisan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-6 text-center text-slate-400">Belum ada artikel atau cerpen yang ditulis.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection