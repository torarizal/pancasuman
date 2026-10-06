@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 relative">
    
    {{-- TOMBOL DIRECT LINK KHUSUS DEVELOPER --}}
    @if(auth()->user()->isDeveloper())
        <div class="absolute top-6 right-6">
            <a href="{{ route('admin.developer.dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-semibold text-sm transition shadow-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Developer Panel
            </a>
        </div>
    @endif

    <h2 class="text-xl font-bold text-gray-800 mb-2">Selamat datang, {{ auth()->user()->name }}!</h2>
    <p class="text-gray-600 mb-6">
        Anda login sebagai: <span class="font-semibold text-blue-600 capitalize">{{ auth()->user()->role }}</span>
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
        <!-- Card Dummy Statistik -->
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
            <h3 class="text-blue-800 font-semibold">Total Kategori</h3>
            <p class="text-2xl font-bold text-blue-900 mt-2">
                {{ \App\Models\Category::count() }}
            </p>
        </div>
        
        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
            <h3 class="text-green-800 font-semibold">Total Artikel</h3>
            <p class="text-2xl font-bold text-green-900 mt-2">0</p>
        </div>

        <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
            <h3 class="text-purple-800 font-semibold">Total Series</h3>
            <p class="text-2xl font-bold text-purple-900 mt-2">0</p>
        </div>
    </div>
</div>
@endsection