@extends('layouts.app')

@section('title', 'Daftar Master Series - Pancasuman')

@section('content')
<div class="space-y-6">
    <div class="border-b border-slate-200 pb-4">
        <h1 class="text-2xl font-black text-slate-900">Master Series / Cerpen Bersambung</h1>
        <p class="text-sm text-slate-500">Kumpulan seri tulisan dan karya bersambung yang dikurasi.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($seriesList as $series)
        <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="flex items-center space-x-2 mb-3">
                    <span class="bg-purple-50 text-purple-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        {{ $series->category->name ?? 'Umum' }}
                    </span>
                </div>
                <h2 class="text-lg font-bold text-slate-900 mb-2">
                    <a href="{{ route('series.show', $series->slug) }}" class="hover:text-blue-600 transition">
                        {{ $series->title }}
                    </a>
                </h2>
                <p class="text-slate-600 text-sm line-clamp-3 mb-4">
                    {{ $series->description ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Oleh <strong class="text-slate-700">{{ $series->author->name ?? 'Anonim' }}</strong></span>
                <a href="{{ route('series.show', $series->slug) }}" class="text-blue-600 font-semibold hover:underline">Lihat Bab &rarr;</a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 bg-white rounded-xl border border-slate-200">
            <p class="text-slate-400">Belum ada Master Series yang tersedia.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $seriesList->links() }}
    </div>
</div>
@endsection