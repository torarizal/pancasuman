<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Developer Panel - Pancasuman')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen font-sans">

    <!-- Sidebar Khusus Developer (Dark Theme) -->
    <aside class="w-64 bg-slate-900 text-slate-300 hidden md:flex md:flex-col">
        <div class="p-6 border-b border-slate-700 bg-slate-950">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                Dev Panel
            </h2>
        </div>
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto text-sm">
            <a href="{{ route('admin.developer.dashboard') }}" class="block px-4 py-2 bg-slate-800 text-white rounded">System Dashboard</a>
            
            <p class="px-4 pt-4 pb-2 text-xs uppercase tracking-wider text-slate-500 font-bold">Struktur Inti</p>
            <a href="{{ route('admin.developer.pages.index') }}" class="block px-4 py-2 hover:bg-slate-800 hover:text-white rounded">Master Pages</a>
            <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 hover:bg-slate-800 hover:text-white rounded">Master Kategori</a>
            <a href="{{ route('admin.series.index') }}" class="block px-4 py-2 hover:bg-slate-800 hover:text-white rounded">Master Series</a>
            <a href="#" class="block px-4 py-2 hover:bg-slate-800 hover:text-white rounded">Menu Navigation</a>
            
            <p class="px-4 pt-4 pb-2 text-xs uppercase tracking-wider text-slate-500 font-bold">Manajemen User</p>
            <a href="#" class="block px-4 py-2 hover:bg-slate-800 hover:text-white rounded">Daftar Users</a>
            <a href="#" class="block px-4 py-2 hover:bg-slate-800 hover:text-white rounded">Roles & Permissions</a>

            <p class="px-4 pt-4 pb-2 text-xs uppercase tracking-wider text-slate-500 font-bold">Konfigurasi</p>
            <a href="#" class="block px-4 py-2 hover:bg-slate-800 hover:text-white rounded">Website Settings</a>
            <a href="#" class="block px-4 py-2 hover:bg-slate-800 hover:text-white rounded">SEO Configuration</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="flex justify-between items-center p-4 bg-white shadow-sm border-b">
            <h1 class="text-xl font-bold text-slate-800">@yield('header')</h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-blue-600 hover:underline">
                    &larr; Kembali ke Admin Konten
                </a>
                <span class="text-slate-600 font-bold">{{ auth()->user()->name }}</span>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>