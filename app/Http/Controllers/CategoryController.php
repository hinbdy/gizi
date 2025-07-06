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
        // --- BAGIAN INI DISEDERHANAKAN ---
        // Kita tidak perlu lagi mengambil daftar artikel di sini.
        // Tugas itu sudah sepenuhnya ditangani oleh komponen Livewire `BlogIndex`.
        // Controller ini sekarang hanya bertugas untuk menampilkan halaman
        // dan mengirimkan informasi kategori mana yang sedang aktif.

        return view('blog.index', [
            // Kita kirimkan seluruh objek $category ke view
            'category' => $category, 
            'title' => 'Artikel Kategori: ' . $category->name,
        ]);
    }
}