@extends(auth()->user()->isDeveloper() ? 'layouts.developer' : 'layouts.admin')

@section('title', 'Tulis Artikel / Cerpen Baru')
@section('header', 'Buat Tulisan Baru')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 max-w-4xl">
    <form action="{{ route('admin.posts.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Judul Tulisan / Cerpen <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required placeholder="Contoh: Menyelami Samudra Makna atau Cerpen Senja di Desa">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-slate-700 text-sm font-bold mb-2">Rubrik / Kategori Utama <span class="text-red-500">*</span></label>
                <select name="category_id" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
                    <option value="">-- Pilih Rubrik --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-slate-700 text-sm font-bold mb-2">Master Series (Opsional)</label>
                <select name="series_id" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500">
                    <option value="">-- Bukan Bagian Series (Tulisan Lepas) --</option>
                    @foreach($seriesList as $series)
                        <option value="{{ $series->id }}" {{ old('series_id') == $series->id ? 'selected' : '' }}>{{ $series->title }}</option>
                    @endforeach
                </select>
                @error('series_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Nomor Volume (Jika masuk Series / Cerpen Bersambung)</label>
            <input type="number" name="volume_number" value="{{ old('volume_number') }}" min="1" class="w-full md:w-1/3 border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" placeholder="Contoh: 1, 2, 3...">
            @error('volume_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- FITUR DEVELOPER OVERRIDE: Slug Manual --}}
        @if(auth()->user()->isDeveloper())
        <div class="mb-4 bg-purple-50 p-4 rounded-lg border border-purple-200">
            <label class="block text-purple-900 text-sm font-bold mb-1">Slug (Developer Manual Override)</label>
            <p class="text-xs text-purple-600 mb-2">Kosongkan jika ingin sistem men-generate otomatis dari judul tulisan.</p>
            <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border border-purple-300 bg-white p-2 rounded focus:outline-none focus:border-purple-500 font-mono text-sm" placeholder="judul-tulisan-custom">
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Ringkasan / Excerpt (Opsional)</label>
            <textarea name="excerpt" rows="2" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" placeholder="Ringkasan singkat isi tulisan untuk preview...">{{ old('excerpt') }}</textarea>
            @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Isi Tulisan / Cerpen <span class="text-red-500">*</span></label>
            <textarea name="body" rows="10" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500 font-mono text-sm" required placeholder="Tulis esai, pemikiran, atau cerpen di sini...">{{ old('body') }}</textarea>
            @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-slate-700 text-sm font-bold mb-2">Status Publikasi <span class="text-red-500">*</span></label>
            <select name="status" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publikasikan Sekarang</option>
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.posts.index') }}" class="text-slate-600 hover:underline">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Simpan Tulisan
            </button>
        </div>
    </form>
</div>
@endsection