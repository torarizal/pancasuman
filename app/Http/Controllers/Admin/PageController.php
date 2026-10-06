<?php

namespace App\Http\Controllers\Admin; // Namespace-nya Admin
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;


class PageController extends Controller
{
    public function index()
{
    $defaultPages = [
        ['title' => 'Tentang Kami', 'slug' => 'tentang-kami'],
        ['title' => 'Kontak Redaksi', 'slug' => 'kontak'],
        ['title' => 'Biografi Cak Nun', 'slug' => 'biografi-cak-nun'],
    ];

    foreach ($defaultPages as $dp) {
        Page::firstOrCreate(
            ['slug' => $dp['slug']],
            ['title' => $dp['title'], 'content' => 'Tulis konten ' . $dp['title'] . ' di sini...']
        );
    }

    $pages = Page::whereIn('slug', ['tentang-kami', 'kontak', 'biografi-cak-nun'])->get();
    
    // Sesuaikan ke folder developer.pages
    return view('developer.pages.index', compact('pages'));
}

    public function edit(Page $page)
    {
        return view('developer.pages.edit', compact('page'));
    }

   public function update(Request $request, Page $page)
{
    // Validasi input
    $request->validate([
        'content' => 'required',
        'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $data = [
        'content' => $request->content,
    ];

    // Cek jika ada file foto yang di-upload
    if ($request->hasFile('image')) {
        // Hapus foto lama di storage jika ada
        if ($page->image && Storage::disk('public')->exists($page->image)) {
            Storage::disk('public')->delete($page->image);
        }

        // Simpan foto baru ke folder 'pages' di public disk
        $path = $request->file('image')->store('pages', 'public');
        $data['image'] = $path;
    }

    // Lakukan update data ke database
    $page->update($data);

    return redirect()->route('admin.developer.pages.index')->with('success', 'Halaman berhasil diperbarui!');
}
}