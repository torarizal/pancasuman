<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Pancasuman')</title>
    <!-- Gunakan Tailwind via CDN untuk testing cepat, nanti kita setup Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md hidden md:flex md:flex-col">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Pancasuman</h2>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-800 rounded">Dashboard</a>
            
            <!-- Menu Kategori (Developer Only atau Admin yg diberi izin) -->
            <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 bg-blue-50 text-blue-700 rounded font-semibold">Manajemen Kategori</a>
            <a href="{{ route('admin.series.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">Master Series</a>
            <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-800 rounded">Manajemen Series</a>
            <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-800 rounded">Artikel</a>
            <a href="{{ route('admin.posts.index') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">Manajemen Artikel</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="flex justify-between items-center p-4 bg-white shadow-sm">
            <h1 class="text-xl font-semibold text-gray-800">@yield('header')</h1>
            <div class="flex items-center space-x-4">
                @if(auth()->user()->isDeveloper())
                    <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded border border-purple-400">Developer Mode</span>
                @endif
                <span class="text-gray-600">{{ auth()->user()->name ?? 'User' }}</span>

                <!-- Tombol Logout -->
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Logout</button>
                </form>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>