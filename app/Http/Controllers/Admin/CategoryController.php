<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        if (! Auth::user()->isDeveloper()) {
            abort(403, 'Akses dibatasi. Hanya akun dengan peran Developer yang dapat membuat kategori baru.');
        }

        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        if (! Auth::user()->isDeveloper()) {
            abort(403, 'Akses dibatasi. Hanya akun dengan peran Developer yang dapat membuat kategori baru.');
        }

        Category::create($request->validated());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        if (! Auth::user()->isDeveloper()) {
            abort(403, 'Akses dibatasi. Hanya akun dengan peran Developer yang dapat mengubah kategori.');
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if (! Auth::user()->isDeveloper()) {
            abort(403, 'Akses dibatasi. Hanya akun dengan peran Developer yang dapat memperbarui kategori.');
        }

        $data = $request->validated();

        // Jika developer tidak mengisi manual slug, biarkan trait HasSlug yang mengurusnya
        if (empty($data['slug'])) {
            unset($data['slug']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if (! Auth::user()->isDeveloper()) {
            abort(403, 'Akses dibatasi. Hanya akun dengan peran Developer yang dapat menghapus kategori.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
