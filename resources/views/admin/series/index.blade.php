@extends('layouts.admin')

@section('title', 'Master Series')
@section('header', 'Manajemen Master Series')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-bold text-slate-800">Daftar Seri Artikel</h2>
        <a href="{{ route('admin.series.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">
            + Tambah Series Baru
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
                    <th class="p-3">Judul Series</th>
                    <th class="p-3">Kategori (Rubrik)</th>
                    <th class="p-3">Slug</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($series as $index => $item)
                <tr>
                    <td class="p-3 text-slate-500">{{ $series->firstItem() + $index }}</td>
                    <td class="p-3 font-semibold text-slate-800">{{ $item->title }}</td>
                    <td class="p-3">
                        <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-medium">
                            {{ $item->category->name ?? 'Tanpa Kategori' }}
                        </span>
                    </td>
                    <td class="p-3 text-slate-500 font-mono text-xs">{{ $item->slug }}</td>
                    <td class="p-3">
                        @if($item->status == 'active')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">Aktif</span>
                        @else
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-semibold">Nonaktif</span>
                        @endif
                    </td>
                    <td class="p-3 text-center space-x-2">
                        <a href="{{ route('admin.series.edit', $item->id) }}" class="text-amber-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('admin.series.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus series ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-slate-400">Belum ada data series yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $series->links() }}
    </div>
</div>
@endsection