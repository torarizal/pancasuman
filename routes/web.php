<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SeriesController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\FrontendController;

// Public Route (Halaman Depan Sementara)
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/tulisan/{slug}', [FrontendController::class, 'show'])->name('posts.show');
Route::get('/rubrik/{slug}', [FrontendController::class, 'category'])->name('category.show');
Route::get('/series', [FrontendController::class, 'seriesIndex'])->name('series.index');
Route::get('/series/{slug}', [FrontendController::class, 'seriesShow'])->name('series.show');
Route::get('/arsip', [FrontendController::class, 'archive'])->name('archive');
Route::get('/penulis', [FrontendController::class, 'authors'])->name('authors.index');
Route::get('/penulis/{id}', [FrontendController::class, 'authorShow'])->name('authors.show');
Route::get('/tentang', [FrontendController::class, 'about'])->name('about');
Route::get('/kontak', [FrontendController::class, 'contact'])->name('contact');
Route::get('/biografi-cak-nun', [FrontendController::class, 'cakNun'])->name('biografi.caknun');

// Guest Routes (Hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// Admin Panel Routes (Auth Protected - Hanya untuk yang sudah login)
// Admin Panel Routes (Auth Protected - Hanya untuk yang sudah login)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Route Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard Admin Biasa
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard'); 

    // Manajemen Kategori (CRUD)
    Route::resource('categories', CategoryController::class);
    Route::resource('series', SeriesController::class);
    Route::resource('posts', PostController::class);
    
   
    // Developer Panel (Khusus Role Developer)
    Route::middleware([\App\Http\Middleware\EnsureIsDeveloper::class])
        ->prefix('developer')
        ->name('developer.')
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('developer.dashboard');
            })->name('dashboard');

            Route::get('/pages', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('pages.index');
            Route::get('/pages/{page}/edit', [\App\Http\Controllers\Admin\PageController::class, 'edit'])->name('pages.edit');
            Route::put('/pages/{page}', [\App\Http\Controllers\Admin\PageController::class, 'update'])->name('pages.update');
            

        });
        });