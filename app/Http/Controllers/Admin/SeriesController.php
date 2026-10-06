<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeriesRequest;
use App\Http\Requests\UpdateSeriesRequest;
use App\Models\Series;
use App\Models\Category;
use Illuminate\Support\Facades\Auth; // <-- PASTIKAN INI ADA DI ATAS!

class SeriesController extends Controller
{
    public function index()
    {
        // Sekarang Auth::user() dan Auth::id() dijamin terbaca dengan sempurna
        if (Auth::user()->role === 'developer') {
            $series = Series::with(['category', 'author'])->latest()->paginate(10);
        } else {
            $series = Series::with(['category', 'author'])
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);
        }

        return view('admin.series.index', compact('series'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.series.create', compact('categories'));
    }

    public function store(StoreSeriesRequest $request)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            unset($data['slug']);
        }

        $data['user_id'] = Auth::id();

        Series::create($data);

        return redirect()->route('admin.series.index')
            ->with('success', 'Series berhasil ditambahkan.');
    }

    public function edit(Series $series)
    {
        if (Auth::user()->role !== 'developer' && $series->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit series ini.');
        }

        $categories = Category::where('status', 'active')->get();
        return view('admin.series.edit', compact('series', 'categories'));
    }

    public function update(UpdateSeriesRequest $request, Series $series)
    {
        if (Auth::user()->role !== 'developer' && $series->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk memperbarui series ini.');
        }

        $data = $request->validated();
        if (empty($data['slug'])) {
            unset($data['slug']);
        }

        $series->update($data);

        return redirect()->route('admin.series.index')
            ->with('success', 'Series berhasil diperbarui.');
    }

    public function destroy(Series $series)
    {
        if (Auth::user()->role !== 'developer' && $series->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus series ini.');
        }

        $series->delete();

        return redirect()->route('admin.series.index')
            ->with('success', 'Series berhasil dihapus.');
    }
}