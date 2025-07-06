<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Category;

class BlogController extends Controller
{
    /**
     * Menampilkan daftar artikel yang sudah dipublikasikan dengan pagination.
     * (Tidak ada perubahan di sini)
     */
    public function index()
    {
        // $articles = Article::with(['author', 'category'])
        //     ->where('published', true)
        //     ->latest()
        //     ->paginate(9);

        // return view('blog.index', [
        //     'articles' => $articles,
        //     'title' => 'Artikel Gizila'
        // ]);

        return view('blog.index', [
        'title' => 'Artikel Gizila'
    ]);
    }

    /**
     * Menampilkan detail artikel.
     */
    public function show(Article $article)
    {
        if (!$article->published) {
            abort(404);
        }

        // Logika penambah views (Tidak ada perubahan)
        $viewed = session()->get('viewed_articles', []);
        if (!in_array($article->id, $viewed)) {
            $article->increment('views');
            session()->push('viewed_articles', $article->id);
        }
        
        $article->load(['author', 'category']);

        // Mendapatkan artikel terkait berdasarkan kategori yang sama (Kode Anda, tidak diubah)
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('published', true)
            ->latest()
            ->take(4)
            ->get();
        
        // Mengambil artikel populer (berdasarkan views terbanyak) (Kode Anda, tidak diubah)
        $popularArticles = Article::where('published', true)
            ->where('id', '!=', $article->id)
            ->orderByDesc('views')
            ->take(5)
            ->get();

         // Mengambil semua kategori beserta jumlah artikelnya (Kode Anda, tidak diubah)
         $categories = Category::withCount(['articles' => function ($query) {
            $query->where('published', true);
        }])
        ->orderBy('name', 'asc')
        ->get();

        // --- MULAI BAGIAN YANG DITAMBAHKAN ---
        // Mengambil 5 artikel TERBARU lainnya untuk sidebar
        $latestArticles = Article::where('published', true)
            ->where('id', '!=', $article->id) // Tidak termasuk artikel yang sedang dibuka
            ->latest() // Mengurutkan berdasarkan tanggal terbaru
            ->take(5)  // Ambil 5 teratas
            ->get();
        // --- AKHIR BAGIAN YANG DITAMBAHKAN ---


        // --- BAGIAN RETURN VIEW DIMODIFIKASI UNTUK MENGIRIM DATA BARU ---
        return view('blog.show', [
            'article' => $article,
            'title' => $article->title,
            'popularArticles' => $popularArticles,
            'latestArticles' => $latestArticles, // <- Kirim data artikel terbaru
            'categories' => $categories,   
            'relatedArticles' => $relatedArticles,
        ]);
    }

    /**
     * Mencari artikel berdasarkan judul/konten.
     * (Tidak ada perubahan di sini)
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