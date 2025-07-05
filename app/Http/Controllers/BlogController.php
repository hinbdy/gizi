<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Category;

class BlogController extends Controller
{
    /**
     * Menampilkan daftar artikel yang sudah dipublikasikan dengan pagination.
     */
    public function index()
    {
        // DIUBAH: ->get() menjadi ->paginate()
        $articles = Article::with(['author', 'category'])
            ->where('published', true)
            ->latest() // latest() adalah singkatan untuk orderBy('created_at', 'desc')
            ->paginate(9); // Ambil 9 artikel per halaman

        return view('blog.index', [
            'articles' => $articles,
            'title' => 'Artikel Gizila'
        ]);
    }

    /**
     * Menampilkan detail artikel.
     * (Tidak ada perubahan, kode Anda sudah bagus)
     */
    public function show(Article $article)
    {
        if (!$article->published) {
            abort(404);
        }

        // --- LOGIKA PENAMBAH VIEWS DIMULAI ---
    $viewed = session()->get('viewed_articles', []);
    if (!in_array($article->id, $viewed)) {
        // increment() lebih efisien daripada $article->views++
        $article->increment('views');
        session()->push('viewed_articles', $article->id);
    }
    // --- LOGIKA PENAMBAH VIEWS SELESAI ---

        $article->load(['author', 'category']);

        // Mendapatkan artikel terkait berdasarkan kategori yang sama
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id) // Tidak termasuk artikel yang sedang dibuka
            ->where('published', true)
            ->latest()
            ->take(4) // Batasi jumlah artikel terkait
            ->get();
        
        // Mengambil artikel populer (berdasarkan views terbanyak)
        $popularArticles = Article::where('published', true)
        ->where('id', '!=', $article->id)
        ->orderByDesc('views')
        ->take(5) // Ambil 5 terpopuler untuk sidebar
        ->get();

         // Mengambil semua kategori beserta jumlah artikelnya
         $categories = Category::withCount(['articles' => function ($query) {
            $query->where('published', true);
        }])
        ->orderBy('name', 'asc')
        ->get();

        return view('blog.show', [
            'article' => $article,
            'title' => $article->title,
            'popularArticles' => $popularArticles,
            'categories' => $categories,   
            'relatedArticles' => $relatedArticles, // Kirim artikel terkait ke view
        ]);
    }

    /**
     * Mencari artikel berdasarkan judul/konten.
     * (Tidak ada perubahan, kode Anda sudah bagus)
     */
    public function search(Request $request)
    {
        $query = $request->query('q');

        $results = Article::where('title', 'LIKE', '%' . $query . '%')
            ->where('published', true)
            ->select('title', 'slug')
            ->limit(5)
            ->get();

        return response()->json($results);
    }
}