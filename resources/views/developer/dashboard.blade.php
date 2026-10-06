@extends('layouts.developer')

@section('title', 'System Dashboard')
@section('header', 'System Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
        <h3 class="text-slate-500 text-sm font-semibold">Total Pengguna</h3>
        <p class="text-3xl font-bold text-slate-800 mt-2">{{ \App\Models\User::count() }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
        <h3 class="text-slate-500 text-sm font-semibold">Total Kategori Master</h3>
        <p class="text-3xl font-bold text-slate-800 mt-2">{{ \App\Models\Category::count() }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
        <h3 class="text-slate-500 text-sm font-semibold">Total Database Size</h3>
        <p class="text-3xl font-bold text-slate-800 mt-2">~ MB</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200 border-l-4 border-l-green-500">
        <h3 class="text-slate-500 text-sm font-semibold">System Status</h3>
        <p class="text-xl font-bold text-green-600 mt-2">Normal / Online</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
    <h2 class="text-lg font-bold text-slate-800 mb-4">Informasi Server & Environment</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <tbody class="divide-y divide-slate-100">
                <tr>
                    <td class="py-3 font-semibold w-1/3">Framework</td>
                    <td class="py-3">Laravel v{{ app()->version() }}</td>
                </tr>
                <tr>
                    <td class="py-3 font-semibold">PHP Version</td>
                    <td class="py-3">{{ phpversion() }}</td>
                </tr>
                <tr>
                    <td class="py-3 font-semibold">Environment</td>
                    <td class="py-3"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs uppercase">{{ app()->environment() }}</span></td>
                </tr>
                <tr>
                    <td class="py-3 font-semibold">Database Connection</td>
                    <td class="py-3">{{ config('database.default') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection