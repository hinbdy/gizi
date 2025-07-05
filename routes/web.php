<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\AboutController;
use App\Models\Food;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Models\Article;
use App\Http\Controllers\CategoryController; 

// Halaman utama

Route::get('/', function () {
    $articles = Article::where('published', true)
                       ->with('author', 'category') // INI WAJIB ADA
                       ->latest()
                       ->take(3)
                       ->get();

    return view('home', [
        'title' => 'home',
        'articles' => $articles
    ]);
})->name('home');


// Route::get('/', function () {
//     return view('home', ['title' => 'home']);
// })->name('home');

// Halaman login & register (view)
Route::get('/login', function () {
    return view('auth.login', ['title' => 'Login']);
})->name('login');

// Route::get('/register', function () {
//     return view('auth.register', ['title' => 'Register']);
// })->name('register');

// Proses login & register (controller)
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Route::post('/register', [RegisterController::class, 'register']);

// Dashboard admin (controller, butuh login)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD Artikel (Controller)
    Route::get('/admin/blog', [AdminBlogController::class, 'index'])->name('admin.blog.index');
    Route::get('/admin/blog/create', [AdminBlogController::class, 'create'])->name('admin.blog.create');
    Route::post('/admin/blog', [AdminBlogController::class, 'store'])->name('admin.blog.store');
    Route::get('/admin/blog/{article}/edit', [AdminBlogController::class, 'edit'])->name('admin.blog.edit');
    Route::put('/admin/blog/{article}', [AdminBlogController::class, 'update'])->name('admin.blog.update');
    Route::delete('/admin/blog/{article}', [AdminBlogController::class, 'destroy'])->name('admin.blog.destroy');
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});


// routes/web.php
// Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile');
    // Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
// });


// Kalkulator Massa Tubuh
Route::get('/kalkulator-massa-tubuh', function () {
    return view('calculator.bmi', ['title' => 'Kalkulator Massa Tubuh']);
})->name('bmi.calculator');

Route::post('/kalkulator-massa-tubuh/hitung', [CalculatorController::class, 'calculateBMI'])->name('bmi.calculate');

// Kalkulator Gizi Harian
// Route::get('/kalkulator-gizi-harian', function () {
//     return view('calculator.nutrition', ['title' => 'Kalkulator Gizi Harian']);
// })->name('nutrition.calculator');

Route::get('/kalkulator-gizi-harian', function () {
    $foods = Food::orderBy('name', 'asc')->get();
    return view('calculator.nutrition', ['title' => 'Kalkulator Gizi Harian', 'foods' => $foods]);
})->name('nutrition.calculator');

Route::post('/kalkulator-gizi-harian/hitung', [CalculatorController::class, 'calculateNutrition'])->name('nutrition.calculate');


// Route::get('/kalkulator-gizi-harian', function () {
//     // Cek apakah session BMI tersedia
//     if (!session()->has('bmi')) {
//         // Redirect dengan flash session untuk menampilkan pop-up
//         return redirect()->route('nutrition.calculator')->with('force_redirect', true);
//     }

//     return view('calculator.nutrition', ['title' => 'Kalkulator Gizi Harian']);
// })->name('nutrition.calculator');


// Route::post('/kalkulator-gizi-harian/hitung', [CalculatorController::class, 'calculateNutrition'])->name('nutrition.calculate');

// Halaman blog publik
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{article}', [BlogController::class, 'show'])->name('blog.show');
// ROUTE BARU UNTUK MENAMPILKAN ARTIKEL BERDASARKAN KATEGORI
Route::get('/kategori/{category:slug}', [CategoryController::class, 'show'])->name('category.show');

// Halaman About (view statis)
Route::get('/about', function () {
    return view('about.index', ['title' => 'Tentang Kami']);
})->name('about.index');

// API Search Artikel (untuk live search di homepage)
Route::get('/api/search-articles', [BlogController::class, 'search'])->name('articles.search');



