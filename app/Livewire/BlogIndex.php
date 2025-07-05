<?php
namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;
    // protected string $paginationTheme = 'bootstrap';
    public function render()
    {
        $articles = Article::where('published', true)
                           ->with('author', 'category')
                           ->latest()
                           ->paginate(9);

        return view('livewire.blog-index', [
            'articles' => $articles,
            'title' => 'Artikel Gizila'
        ]);
    }
}