@extends('layouts.developer')

@section('title', 'Manajemen Pengguna & Hak Akses - Developer')
@section('header', 'Manajemen Pengguna & Hak Akses')

@section('content')
<div class="space-y-6">

    {{-- Top Action & Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white tracking-tight">Daftar Akun Pengguna</h2>
            <p class="text-xs text-slate-400 mt-1">Kelola seluruh kredensial pengelola portal, hak akses (role), dan status akun.</p>
        </div>
        <a href="{{ route('admin.developer.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs shadow-lg shadow-purple-600/30 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Tambah Akun Baru</span>
        </a>
    </div>

    {{-- Filter & Pencarian --}}
    <div class="bg-slate-950/70 border border-slate-800 rounded-2xl p-4 shadow-xl">
        <form action="{{ route('admin.developer.users.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email akun..." class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-purple-500">
            </div>

            <div class="w-full sm:w-48">
                <select name="role" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-800 text-xs text-slate-200 focus:outline-none focus:border-purple-500">
                    <option value="">Semua Peran (Role)</option>
                    <option value="developer" {{ request('role') == 'developer' ? 'selected' : '' }}>Developer</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="penulis" {{ request('role') == 'penulis' ? 'selected' : '' }}>Penulis</option>
                </select>
            </div>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold transition cursor-pointer">
                Filter
            </button>

            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('admin.developer.users.index') }}" class="w-full sm:w-auto px-3 py-2 rounded-xl text-slate-400 hover:text-slate-200 text-xs font-semibold text-center transition">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Tabel Pengguna --}}
    <div class="bg-slate-950/70 rounded-2xl shadow-xl border border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-900 border-b border-slate-800 text-slate-400 text-xs font-mono uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Pengguna</th>
                        <th class="p-4">Peran / Role</th>
                        <th class="p-4 text-center">Total Artikel</th>
                        <th class="p-4">Terdaftar</th>
                        <th class="p-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-900/40 transition">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full overflow-hidden bg-slate-800 border border-slate-700 flex items-center justify-center shrink-0">
                                    @if($u->avatar)
                                        <img src="{{ asset('storage/' . $u->avatar) }}" alt="{{ $u->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs font-bold text-slate-300">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-bold text-white flex items-center gap-2">
                                        <span>{{ $u->name }}</span>
                                        @if($u->id === auth()->id())
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-purple-900/60 text-purple-300 border border-purple-700/60 font-mono">Anda</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $u->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            @if($u->role === 'developer')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-950/80 border border-purple-700 text-purple-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span>
                                    <span>Developer</span>
                                </span>
                            @elseif($u->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-950/80 border border-blue-700 text-blue-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                                    <span>Admin</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-900 border border-slate-700 text-slate-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    <span>Penulis</span>
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <span class="font-mono text-xs font-bold text-slate-300">{{ $u->posts_count }} karya</span>
                        </td>
                        <td class="p-4 text-xs text-slate-400 font-mono">
                            {{ $u->created_at->format('d M Y') }}
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.developer.users.edit', $u->id) }}" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition" title="Edit Akun">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                @if($u->id !== auth()->id())
                                    <form action="{{ route('admin.developer.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}? Tindakan ini tidak dapat dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-950/60 hover:bg-rose-900 text-rose-300 hover:text-white border border-rose-800/60 transition cursor-pointer" title="Hapus Akun">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500 text-xs">
                            Tidak ditemukan akun dengan filter tersebut.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-slate-800">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
