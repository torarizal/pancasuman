@extends(auth()->user()->isDeveloper() ? 'layouts.developer' : 'layouts.admin')

@section('title', 'Tambah Series Baru')
@section('header', 'Tambah Series')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 max-w-2xl">
    <form action="{{ route('admin.series.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Judul Series <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required placeholder="Contoh: Seri Menek Blimbing">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Kategori (Rubrik) <span class="text-red-500">*</span></label>
            <select name="category_id" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
                <option value="">-- Pilih Rubrik Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Upload Cover Image Series --}}
        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Gambar Sampul Series / Cover Image (Opsional)</label>
            <input type="file" name="cover_image" id="cover_image_input" accept="image/*" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500 bg-white text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
            <p class="text-xs text-slate-500 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal 5MB.</p>
            @error('cover_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            
            {{-- Preview Gambar --}}
            <div id="image_preview_wrapper" class="hidden mt-3">
                <p class="text-xs font-semibold text-slate-600 mb-1">Pratinjau Sampul Series:</p>
                <img id="image_preview" src="" alt="Pratinjau" class="w-48 h-32 object-cover rounded-lg border border-slate-200 shadow-xs">
            </div>
        </div>

        {{-- FITUR DEVELOPER OVERRIDE: Slug Manual --}}
        @if(auth()->user()->isDeveloper())
        <div class="mb-4 bg-purple-50 p-4 rounded-lg border border-purple-200">
            <label class="block text-purple-900 text-sm font-bold mb-1">Slug (Developer Manual Override)</label>
            <p class="text-xs text-purple-600 mb-2">Kosongkan jika ingin sistem men-generate otomatis dari judul series.</p>
            <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border border-purple-300 bg-white p-2 rounded focus:outline-none focus:border-purple-500 font-mono text-sm" placeholder="seri-menek-blimbing">
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-slate-700 text-sm font-bold mb-2">Deskripsi / Sinopsis</label>
            <textarea name="description" rows="3" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" placeholder="Penjelasan singkat mengenai isi seri tulisan ini...">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-slate-700 text-sm font-bold mb-2">Status <span class="text-red-500">*</span></label>
            <select name="status" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.series.index') }}" class="text-slate-600 hover:underline">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Simpan Series
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('cover_image_input');
        const previewWrapper = document.getElementById('image_preview_wrapper');
        const previewImg = document.getElementById('image_preview');

        if (imageInput) {
            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewWrapper.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewWrapper.classList.add('hidden');
                }
            });
        }
    });
</script>
@endsection