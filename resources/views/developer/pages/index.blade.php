@extends('layouts.app') {{-- Ganti dengan layout developer/admin kamu --}}

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-slate-900 mb-6">Edit Konten Halaman Statis</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="p-4 font-semibold text-slate-700">Halaman</th>
                    <th class="p-4 font-semibold text-slate-700 w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                <tr class="border-b border-slate-100">
                    <td class="p-4 font-bold text-slate-900">{{ $page->title }}</td>
                    <td class="p-4">
                        <a href="{{ route('admin.developer.pages.edit', $page->id) }}" class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-200">
                            Edit Teks
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection