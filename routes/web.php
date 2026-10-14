<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Developer\SettingController;
use App\Http\Controllers\Admin\Developer\UserController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SeriesController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontendController;
use App\Http\Middleware\EnsureIsDeveloper;
use Illuminate\Support\Facades\Route;

// Public Route (Portal Literasi Pancasuman)
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
Route::get('/artikel', [FrontendController::class, 'articles'])->name('articles');
Route::get('/galeri', [FrontendController::class, 'gallery'])->name('gallery.index');
Route::get('/video', [FrontendController::class, 'gallery'])->name('video.index');

// Guest Routes (Hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// Admin Panel Routes (Auth Protected - Hanya untuk yang sudah login)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Route Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard Admin Biasa
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Pengaturan Profil Sendiri (Admin, Penulis, & Developer)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Manajemen Kategori (Index untuk semua, Create/Edit/Delete dikunci Developer)
    Route::resource('categories', CategoryController::class);
    Route::resource('series', SeriesController::class);
    Route::resource('posts', PostController::class);

    // Manajemen Galeri Foto & Video
    Route::resource('galleries', GalleryController::class);
    Route::resource('videos', VideoController::class);

    // Developer Panel (Khusus Role Developer)
    Route::middleware([EnsureIsDeveloper::class])
        ->prefix('developer')
        ->name('developer.')
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('developer.dashboard');
            })->name('dashboard');

            // Manajemen Pengguna & Hak Akses
            Route::resource('users', UserController::class);

            // Pengaturan Logo & Identitas Website
            Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
            Route::put('/settings/logo', [SettingController::class, 'updateLogo'])->name('settings.logo.update');
            Route::delete('/settings/logo', [SettingController::class, 'destroyLogo'])->name('settings.logo.destroy');

            // Master Halaman Statis
            Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
            Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
            Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
        });
});
