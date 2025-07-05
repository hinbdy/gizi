<?php
// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan artikel berdasarkan kategori yang dipilih.
     */
    public function show(Category $category)
    {
        // Ambil artikel yang berelasi dengan kategori ini,
        // yang sudah dipublish, urutkan dari terbaru, dan paginasi.
        $articles = $category->articles()
            ->where('published', true)
            ->with('author', 'category')
            ->latest()
            ->paginate(9);

        // Kita akan menggunakan view yang sama dengan halaman blog utama
        // Namun dengan judul yang berbeda
        return view('blog.index', [
            'articles' => $articles,
            'title' => 'Artikel dalam Kategori: ' . $category->name,
        ]);
    }
}