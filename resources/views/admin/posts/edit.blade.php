@extends(auth()->user()->isDeveloper() ? 'layouts.developer' : 'layouts.admin')

@section('title', 'Edit Artikel / Cerpen')
@section('header', 'Edit Tulisan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 max-w-4xl">
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Judul Tulisan / Cerpen <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-slate-700 text-sm font-bold mb-2">Rubrik / Kategori Utama <span class="text-red-500">*</span></label>
                <select name="category_id" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-slate-700 text-sm font-bold mb-2">Master Series (Opsional)</label>
                <select name="series_id" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500">
                    <option value="">-- Bukan Bagian Series (Tulisan Lepas) --</option>
                    @foreach($seriesList as $series)
                        <option value="{{ $series->id }}" {{ old('series_id', $post->series_id) == $series->id ? 'selected' : '' }}>{{ $series->title }}</option>
                    @endforeach
                </select>
                @error('series_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Nomor Volume (Jika masuk Series / Cerpen Bersambung)</label>
            <input type="number" name="volume_number" value="{{ old('volume_number', $post->volume_number) }}" min="1" class="w-full md:w-1/3 border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500">
            @error('volume_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- FITUR DEVELOPER OVERRIDE: Slug Manual --}}
        @if(auth()->user()->isDeveloper())
        <div class="mb-4 bg-purple-50 p-4 rounded-lg border border-purple-200">
            <label class="block text-purple-900 text-sm font-bold mb-1">Slug (Developer Manual Override)</label>
            <p class="text-xs text-purple-600 mb-2">Kosongkan jika ingin sistem men-generate ulang secara otomatis.</p>
            <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" class="w-full border border-purple-300 bg-white p-2 rounded focus:outline-none focus:border-purple-500 font-mono text-sm">
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Ringkasan / Excerpt (Opsional)</label>
            <textarea name="excerpt" rows="2" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500">{{ old('excerpt', $post->excerpt) }}</textarea>
            @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Isi Tulisan / Cerpen <span class="text-red-500">*</span></label>
            <textarea name="body" rows="10" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500 font-mono text-sm" required>{{ old('body', $post->body) }}</textarea>
            @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-slate-700 text-sm font-bold mb-2">Status Publikasi <span class="text-red-500">*</span></label>
            <select name="status" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Publikasikan Sekarang</option>
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.posts.index') }}" class="text-slate-600 hover:underline">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Perbarui Tulisan
            </button>
        </div>
    </form>
</div>
@endsection