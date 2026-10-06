@extends(auth()->user()->isDeveloper() ? 'layouts.developer' : 'layouts.admin')

@section('title', 'Edit Kategori')
@section('header', 'Edit Kategori')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 max-w-2xl">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- FITUR DEVELOPER OVERRIDE: Slug Manual --}}
        @if(auth()->user()->isDeveloper())
        <div class="mb-4 bg-purple-50 p-4 rounded-lg border border-purple-200">
            <label class="block text-purple-900 text-sm font-bold mb-1">Slug (Developer Manual Override)</label>
            <p class="text-xs text-purple-600 mb-2">Kosongkan jika ingin sistem men-generate ulang secara otomatis dari nama kategori.</p>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="w-full border border-purple-300 bg-white p-2 rounded focus:outline-none focus:border-purple-500 font-mono text-sm">
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500">{{ old('description', $category->description) }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-slate-700 text-sm font-bold mb-2">Status <span class="text-red-500">*</span></label>
            <select name="status" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
                <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message ? $message : '' }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.categories.index') }}" class="text-slate-600 hover:underline">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Perbarui Kategori
            </button>
        </div>
    </form>
</div>
@endsection