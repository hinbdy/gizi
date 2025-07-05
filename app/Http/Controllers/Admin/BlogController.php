<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Diaktifkan kembali untuk membuat slug kategori

class BlogController extends Controller
{
    /**
     * Tampilkan daftar artikel di dashboard admin.
     */
    public function index()
    {
        $articles = Article::with('category', 'author')->orderByDesc('created_at')->get();
        return view('admin.blog.index', compact('articles'));
    }

    /**
     * Tampilkan form untuk membuat artikel baru.
     * DIUBAH: Tidak perlu lagi mengirim data kategori.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Simpan artikel baru ke database.
     * DIUBAH: Menggunakan logika "Find or Create".
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'         => 'required|string|max:255',
            'excerpt'       => 'nullable|string',
            'content'       => 'required|string',
            'category_name' => 'required|string|max:100', // Validasi input teks 'category_name'
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'published'     => 'required|boolean',
        ]);

        // Logika "Find or Create" untuk Kategori
        $category = Category::firstOrCreate(
            ['name' => $validatedData['category_name']], // Cari berdasarkan nama
            ['slug' => Str::slug($validatedData['category_name'])] // Jika tidak ada, buat baru dengan slug ini
        );

        // Siapkan data untuk disimpan ke tabel articles
        $articleData = $validatedData;
        unset($articleData['category_name']); // Hapus 'category_name' karena tidak ada di tabel articles
        $articleData['category_id'] = $category->id; // Tambahkan 'category_id' yang benar
        
        if ($request->hasFile('thumbnail')) {
            $articleData['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $articleData['user_id'] = auth()->id();
        $articleData['views'] = 0;
        
        Article::create($articleData);

        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Tampilkan form untuk mengedit artikel.
     * DIUBAH: Tidak perlu lagi mengirim data kategori.
     */
    public function edit(Article $article)
    {
        return view('admin.blog.edit', compact('article'));
    }

    /**
     * Perbarui data artikel yang sudah ada.
     * DIUBAH: Menggunakan logika "Find or Create".
     */
    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title'         => 'required|string|max:255',
            'excerpt'       => 'nullable|string',
            'content'       => 'required|string',
            'category_name' => 'required|string|max:100', // Validasi input teks 'category_name'
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'published'     => 'required|boolean',
        ]);
        
        // Logika "Find or Create" untuk Kategori
        $category = Category::firstOrCreate(
            ['name' => $validatedData['category_name']],
            ['slug' => Str::slug($validatedData['category_name'])]
        );
        
        // Siapkan data untuk diupdate
        $articleData = $validatedData;
        unset($articleData['category_name']);
        $articleData['category_id'] = $category->id;

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $articleData['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        
        $article->update($articleData);

        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Hapus artikel dari database.
     */
    public function destroy(Article $article)
    {
        if ($article->thumbnail) {
        Storage::disk('public')->delete($article->thumbnail); 
    }

        $article->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil dihapus.');
    }
}