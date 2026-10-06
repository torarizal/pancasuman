@extends(auth()->user()->isDeveloper() ? 'layouts.developer' : 'layouts.admin')

@section('title', 'Edit Series')
@section('header', 'Edit Series')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 max-w-2xl">
    <form action="{{ route('admin.series.update', $series->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Judul Series <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $series->title) }}" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Kategori (Rubrik) <span class="text-red-500">*</span></label>
            <select name="category_id" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $series->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- FITUR DEVELOPER OVERRIDE: Slug Manual --}}
        @if(auth()->user()->isDeveloper())
        <div class="mb-4 bg-purple-50 p-4 rounded-lg border border-purple-200">
            <label class="block text-purple-900 text-sm font-bold mb-1">Slug (Developer Manual Override)</label>
            <p class="text-xs text-purple-600 mb-2">Kosongkan jika ingin sistem men-generate ulang secara otomatis.</p>
            <input type="text" name="slug" value="{{ old('slug', $series->slug) }}" class="w-full border border-purple-300 bg-white p-2 rounded focus:outline-none focus:border-purple-500 font-mono text-sm">
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Deskripsi / Sinopsis</label>
            <textarea name="description" rows="3" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500">{{ old('description', $series->description) }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-slate-700 text-sm font-bold mb-2">Status <span class="text-red-500">*</span></label>
            <select name="status" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
                <option value="active" {{ old('status', $series->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status', $series->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.series.index') }}" class="text-slate-600 hover:underline">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Perbarui Series
            </button>
        </div>
    </form>
</div>
@endsection