<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ArticleView; 

class BlogController extends Controller
{
    public function index()
    {
        // Query dasar untuk artikel
        $query = Article::with('category', 'author')->latest();
        $activeCategory = null; 

         if (request('category')) {
            // Cari kategori berdasarkan slug
            $category = Category::where('slug', request('category'))->firstOrFail();
            $activeCategory = $category->name; // Simpan nama kategori

            // Filter query artikel berdasarkan ID kategori
            $query->where('category_id', $category->id);
        }

        // Terapkan filter pencarian jika ada input 'search'
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        // Ambil data dengan pagination (10 artikel per halaman)
        $articles = $query->paginate(10);

        return view('admin.blog.index', [
            'articles' => $articles,
            'activeCategory' => $activeCategory,
        ]);
    }

    //Tampilkan form untuk membuat artikel baru.
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Simpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'         => 'required|string|max:255',
            'excerpt'       => 'nullable|string',
            'content'       => 'required|string',
            'category_name' => 'required|string|max:100',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'published'     => 'required|boolean',
        ]);

        $category = Category::firstOrCreate(
            ['name' => $validatedData['category_name']],
            ['slug' => Str::slug($validatedData['category_name'])]
        );

        $articleData = $validatedData;
        unset($articleData['category_name']);
        $articleData['category_id'] = $category->id;
        
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
     */
    public function edit(Article $article)
    {
        return view('admin.blog.edit', compact('article'));
    }

    /**
     * Perbarui data artikel yang sudah ada.
     */
    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title'         => 'required|string|max:255',
            'excerpt'       => 'nullable|string',
            'content'       => 'required|string',
            'category_name' => 'required|string|max:100',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'published'     => 'required|boolean',
        ]);
        
        $category = Category::firstOrCreate(
            ['name' => $validatedData['category_name']],
            ['slug' => Str::slug($validatedData['category_name'])]
        );
        
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