<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Series;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;

class FrontendController extends Controller
{
    // Halaman Utama / Beranda Portal
    public function index()
    {
        // Ambil artikel yang statusnya 'published', urutkan dari yang terbaru
        $posts = Post::with(['category', 'series', 'author'])
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->paginate(9);

        // Ambil daftar kategori aktif untuk widget menu rubrik
        $categories = Category::where('status', 'active')->get();

        // Ambil beberapa Master Series terbaru
        $seriesList = Series::with(['category', 'author'])
                            ->where('status', 'active')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('frontend.index', compact('posts', 'categories', 'seriesList'));
    }

    // Halaman Detail Baca Artikel / Cerpen
    public function show($slug)
    {
        $post = Post::with(['category', 'series', 'author'])
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        // Ambil artikel lain dalam series yang sama (jika ini bagian dari cerpen bersambung)
        $seriesPosts = [];
        if ($post->series_id) {
            $seriesPosts = Post::where('series_id', $post->series_id)
                                ->where('status', 'published')
                                ->orderBy('volume_number', 'asc')
                                ->get();
        }

        return view('frontend.show', compact('post', 'seriesPosts'));
    }

    // Halaman Arsip Berdasarkan Kategori (Rubrik)
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('status', 'active')->firstOrFail();
        
        $posts = Post::with(['series', 'author'])
                    ->where('category_id', $category->id)
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->paginate(9);

        $categories = Category::where('status', 'active')->get();

        return view('frontend.category', compact('category', 'posts', 'categories'));
    }

    // Halaman Daftar Seluruh Series / Cerpen Bersambung
    public function seriesIndex()
    {
        $seriesList = Series::with(['category', 'author'])
                            ->where('status', 'active')
                            ->latest()
                            ->paginate(9);

        return view('frontend.series-index', compact('seriesList'));
    }

    // Halaman Detail Series (Menampilkan daftar volume/bab dari sebuah cerpen bersambung)
    public function seriesShow($slug)
    {
        $series = Series::with(['category', 'author'])->where('slug', $slug)->firstOrFail();
        
        $posts = Post::where('series_id', $series->id)
                    ->where('status', 'published')
                    ->orderBy('volume_number', 'asc')
                    ->paginate(10);

        return view('frontend.series-show', compact('series', 'posts'));
    }

    // Halaman Arsip & Pencarian
    public function archive(Request $request)
    {
        $query = Post::with(['category', 'series', 'author'])->where('status', 'published');

        // Jika ada input pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('body', 'like', '%' . $search . '%');
            });
        }

        // Pagination 12 item per halaman dan bawa query string pencarian
        $posts = $query->latest('published_at')->paginate(12)->withQueryString();

        return view('frontend.archive', compact('posts'));
    }

    // Halaman Daftar Penulis (Direktori)
    public function authors()
    {
        // Ambil user yang sudah pernah mempublikasikan minimal 1 tulisan
        $authors = User::whereHas('posts', function($query) {
            $query->where('status', 'published');
        })->withCount(['posts' => function($query) {
            $query->where('status', 'published');
        }])->orderBy('posts_count', 'desc')->paginate(12);

        return view('frontend.authors', compact('authors'));
    }

    // Halaman Profil Penulis & Daftar Karyanya
    public function authorShow($id)
    {
        $author = User::findOrFail($id);
        
        $posts = Post::with(['category', 'series'])
                    ->where('user_id', $id)
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->paginate(9);

        return view('frontend.author-show', compact('author', 'posts'));
    }

    // Halaman Tentang Kami
   public function about()
    {
        $page = Page::where('slug', 'tentang-kami')->first();
        return view('frontend.about', compact('page'));
    }

    public function contact()
    {
        $page = Page::where('slug', 'kontak')->first();
        return view('frontend.contact', compact('page'));
    }

    public function cakNun()
    {
        $page = Page::where('slug', 'biografi-cak-nun')->first();
        return view('frontend.caknun', compact('page'));
    }
}