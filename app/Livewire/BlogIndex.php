<?php
namespace App\Livewire;

use App\Models\Article;
use App\Models\Category; 
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class BlogIndex extends Component
{
    use WithPagination;
    // protected string $paginationTheme = 'bootstrap';

    protected string $paginationTheme = 'vendor.pagination.tailwind';
    

    #[Url(except: '')]
    public string $search = '';

   // Properti untuk menampung slug kategori dari URL
    public ?string $categorySlug = null; 
    public ?string $categoryName = null;
    
     // Method `mount` akan berjalan sekali saat komponen pertama kali dimuat
    public function mount($categorySlug = null)
    {
        $this->categorySlug = $categorySlug;
        if ($this->categorySlug) {
            // Cari nama kategori berdasarkan slug untuk ditampilkan di judul
            $category = Category::where('slug', $this->categorySlug)->first();
            $this->categoryName = $category ? $category->name : null;
        }
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // --- MULAI BAGIAN YANG PERLU DIMODIFIKASI ---
        $articles = Article::query() // Ganti `Article::where` menjadi `Article::query()` untuk memulai query builder
                           ->where('published', true)
                           // Tambahkan blok `when` untuk menerapkan filter pencarian
                           ->when($this->search, function ($query) {
                               $query->where('title', 'like', '%' . $this->search . '%');
                           })

                            // Tambahkan filter berdasarkan kategori jika ada
                            ->when($this->categorySlug, function ($query) {
                                $query->whereHas('category', function ($subQuery) {
                                    $subQuery->where('slug', $this->categorySlug);
                                });
                            })
                           ->with('author', 'category')
                           ->latest()
                           ->paginate(9);
 
         // Judul halaman dinamis berdasarkan kategori
        $title = 'Artikel Edukasi Gizila';
        if($this->categoryName) {
            $title = 'Artikel Kategori: ' . $this->categoryName;
        }

        return view('livewire.blog-index', [
            'articles' => $articles,
            'title' => 'Artikel Gizila'
        ]);
    }
}