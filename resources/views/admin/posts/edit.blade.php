@extends(auth()->user()->isDeveloper() ? 'layouts.developer' : 'layouts.admin')

@section('title', 'Edit Artikel / Cerpen')
@section('header', 'Edit Tulisan')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xs border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 max-w-4xl">
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">Judul Tulisan / Cerpen <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">Rubrik / Kategori Utama <span class="text-red-500">*</span></label>
                <select name="category_id" class="w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">Master Series (Opsional)</label>
                <select name="series_id" class="w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <option value="">-- Bukan Bagian Series (Tulisan Lepas) --</option>
                    @foreach($seriesList as $series)
                        <option value="{{ $series->id }}" {{ old('series_id', $post->series_id) == $series->id ? 'selected' : '' }}>{{ $series->title }}</option>
                    @endforeach
                </select>
                @error('series_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">Nomor Volume (Jika masuk Series / Cerpen Bersambung)</label>
            <input type="number" name="volume_number" value="{{ old('volume_number', $post->volume_number) }}" min="1" class="w-full md:w-1/3 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            @error('volume_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Upload Gambar Sampul (Featured Image) --}}
        <div class="mb-4">
            <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">Gambar Sampul / Featured Image (Opsional)</label>
            @if($post->featured_image)
                <div class="mb-3">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Gambar saat ini:</p>
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Sampul saat ini" loading="lazy" decoding="async" class="w-48 h-32 object-cover rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
                </div>
            @endif
            <input type="file" name="featured_image" id="featured_image_input" accept="image/*" class="w-full border border-slate-300 dark:border-slate-700 p-2 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 dark:file:bg-blue-950/60 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 cursor-pointer">
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal 5MB. Kosongkan jika tidak ingin mengubah gambar.</p>
            @error('featured_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            {{-- Preview Gambar Baru --}}
            <div id="image_preview_wrapper" class="hidden mt-3">
                <p class="text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1">Pratinjau Gambar Baru:</p>
                <img id="image_preview" src="" alt="Pratinjau" class="w-48 h-32 object-cover rounded-xl border border-slate-200 dark:border-slate-700 shadow-xs">
            </div>
        </div>

        {{-- FITUR DEVELOPER OVERRIDE: Slug Manual --}}
        @if(auth()->user()->isDeveloper())
        <div class="mb-4 bg-purple-50 dark:bg-purple-950/40 p-4 rounded-xl border border-purple-200 dark:border-purple-800/60">
            <label class="block text-purple-900 dark:text-purple-300 text-sm font-bold mb-1">Slug (Developer Manual Override)</label>
            <p class="text-xs text-purple-600 dark:text-purple-400 mb-2">Kosongkan jika ingin sistem men-generate ulang secara otomatis.</p>
            <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" class="w-full border border-purple-300 dark:border-purple-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 font-mono text-sm">
            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        @endif

        <div class="mb-4">
            <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">Ringkasan / Excerpt (Opsional)</label>
            <textarea name="excerpt" rows="2" class="w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ old('excerpt', $post->excerpt) }}</textarea>
            @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">Isi Tulisan / Cerpen <span class="text-red-500">*</span></label>
            <textarea name="body" rows="10" class="w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono text-sm" required>{{ old('body', $post->body) }}</textarea>
            @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">Status Publikasi <span class="text-red-500">*</span></label>
            <select name="status" class="w-full border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-2.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Publikasikan Sekarang</option>
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Pengaturan SEO & Meta Tags --}}
        <div class="mb-6 bg-slate-50 dark:bg-slate-800/60 p-5 rounded-2xl border border-slate-200 dark:border-slate-700">
            <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-3 uppercase tracking-wider">Pengaturan SEO (Opsional)</h3>
            
            <div class="mb-4">
                <label class="block text-slate-700 dark:text-slate-300 text-xs font-bold mb-1">Meta Title (Judul untuk Google/Sosmed)</label>
                <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title ?? '') }}" class="w-full border border-slate-300 dark:border-slate-700 p-2.5 rounded-xl text-sm bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Kosongkan jika ingin sama dengan judul utama">
                @error('meta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-slate-700 dark:text-slate-300 text-xs font-bold mb-1">Meta Description (Ringkasan SEO - Maks 160 karakter)</label>
                <textarea name="meta_description" rows="2" class="w-full border border-slate-300 dark:border-slate-700 p-2.5 rounded-xl text-sm bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tulis deskripsi singkat yang menarik perhatian pembaca di hasil pencarian...">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                @error('meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('admin.posts.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:underline text-sm font-semibold">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-xs cursor-pointer">
                Perbarui Tulisan
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('featured_image_input');
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