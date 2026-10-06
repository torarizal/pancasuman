@extends('layouts.app')

@section('title', 'Direktori Penulis - Pancasuman')

@section('content')
<div class="space-y-8">
    <div class="border-b border-slate-200 pb-4 text-center">
        <h1 class="text-3xl font-black text-slate-900">Penulis Pancasuman</h1>
        <p class="text-slate-500 mt-2">Mengenal lebih dekat para kontributor dan karya-karya mereka.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @forelse($authors as $author)
        <a href="{{ route('authors.show', $author->id) }}" class="bg-white border border-slate-200 rounded-2xl p-6 text-center shadow-sm hover:shadow-md hover:border-blue-300 transition group flex flex-col items-center">
            <div class="w-20 h-20 bg-gradient-to-tr from-blue-500 to-purple-500 text-white rounded-full flex items-center justify-center text-3xl font-black mb-4 shadow-inner group-hover:scale-110 transition-transform">
                {{ substr($author->name, 0, 1) }}
            </div>
            <h3 class="font-bold text-slate-800 text-sm mb-1 group-hover:text-blue-600">{{ $author->name }}</h3>
            <span class="text-xs font-medium text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                {{ $author->posts_count }} Tulisan
            </span>
        </a>
        @empty
        <div class="col-span-full text-center py-12 text-slate-400">
            Belum ada penulis yang mempublikasikan karya.
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $authors->links() }}
    </div>
</div>
@endsection