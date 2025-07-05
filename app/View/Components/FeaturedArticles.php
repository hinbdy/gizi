<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class FeaturedArticles extends Component
{
    public $articles; // Properti untuk menampung data artikel

    /**
     * Buat instance komponen baru.
     */
    public function __construct($articles)
    {
        $this->articles = $articles; // Terima data artikel saat komponen dipanggil
    }

    /**
     * Dapatkan view / konten yang merepresentasikan komponen.
     */
    public function render(): View
    {
        return view('components.featured-articles');
    }
}