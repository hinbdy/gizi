<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\AboutController;
use App\Models\Food;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Models\Article;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\IsAdminMiddleware;





// Halaman utama

// TAMBAHKAN KODE INI UNTUK MENGALIHKAN DARI '/' KE '/home'
Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', function () {
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


Route::prefix('admin')->middleware(['auth', IsAdminMiddleware::class])->name('admin.')->group(function () {
    // Rute Baru untuk Manajemen Hak Akses
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
});


// Dashboard admin (controller, butuh login)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD Artikel (Controller)
    Route::get('/admin/blog', [AdminBlogController::class, 'index'])->name('admin.blog.index');
    Route::get('/admin/blog/create', [AdminBlogController::class, 'create'])->name('admin.blog.create');
    Route::post('/admin/blog', [AdminBlogController::class, 'store'])->name('admin.blog.store');
    Route::get('/admin/blog/{article:slug}/edit', [AdminBlogController::class, 'edit'])->name('admin.blog.edit');
    Route::put('/admin/blog/{article:slug}', [AdminBlogController::class, 'update'])->name('admin.blog.update');
    Route::delete('/admin/blog/{article}', [AdminBlogController::class, 'destroy'])->name('admin.blog.destroy');
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::resource('/admin/categories', AdminCategoryController::class)->names('admin.categories');
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

// Route::get('/kalkulator-gizi-harian', function () {
//     $foods = Food::orderBy('name', 'asc')->get();
//     return view('calculator.nutrition', ['title' => 'Kalkulator Gizi Harian', 'foods' => $foods]);
// })->name('nutrition.calculator');


// ROUTE #1: Untuk MENAMPILKAN halaman form (GET)
Route::get('/kalkulator-gizi-harian', function () {
    
    // 1. Cek dari mana pengguna datang (URL sebelumnya)
    $previousUrl = URL::previous();

    // 2. Jika pengguna TIDAK datang dari halaman hasil BMI, maka kita anggap
    //    ini adalah kunjungan baru atau refresh. Hapus sesi BMI.
    //    Ganti 'gizila.test' dengan URL lokal Anda jika berbeda.
    // if (!str_contains($previousUrl, '/kalkulator-massa-tubuh/hitung')) {
    //     session()->forget(['bmi', 'bmr']);
    // }
    
    // 3. Lanjutkan dengan kode Anda yang sudah ada untuk mengambil data makanan
    $foods = Food::select(
        'id',   
                'name', 
                'image_url', 
                DB::raw('MIN(id) as id'),
                DB::raw('MIN(calories) as calories')
                )
                 ->groupBy('id', 'name', 'image_url')
                 ->orderBy('name', 'asc')
                 ->get();

     $bmiData = session()->only([
        'bmi', 'kategoriIMT', 'kategoriBB', 'bbImage', 'imtImage', 
        'idealImage', 'bmr', 'berat', 'tinggi', 'beratIdeal', 'selisihBerat'
    ]);
    
    // 4. Kirim data ke view
    return view('calculator.nutrition', [
        'title' => 'Kalkulator Gizi Harian',
        'foods' => $foods,
        'bmiData' => $bmiData
    ]);
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



