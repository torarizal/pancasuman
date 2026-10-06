<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pancasuman - Portal Komunitas & Literasi')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    {{-- Navbar Publik --}}
    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-black tracking-tight text-blue-600">
                PANCASUMAN<span class="text-slate-400 font-light text-sm ml-1">Portal</span>
            </a>
            <div class="space-x-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-slate-600 hover:text-blue-600">Beranda</a>
                <a href="{{ route('archive') }}" class="text-slate-600 hover:text-blue-600">Eksplor</a>
                <a href="{{ route('authors.index') }}" class="text-slate-600 hover:text-blue-600">Penulis</a>
                <a href="{{ route('series.index') }}" class="text-slate-600 hover:text-blue-600">Series</a>
                <a href="{{ route('biografi.caknun') }}" class="text-slate-500 hover:text-blue-600">Biografi Cak Nun</a>
                <a href="{{ route('about') }}" class="text-slate-500 hover:text-blue-600">Tentang Kami</a>
                <a href="{{ route('contact') }}" class="text-slate-500 hover:text-blue-600">Kontak</a>
            </div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Dashboard Admin</a>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500 mt-12">
        <p>&copy; {{ date('Y') }} Pancasuman Community Portal. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>