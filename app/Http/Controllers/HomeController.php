<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get latest articles for the New Product section
        $latestArticles = Article::latest()->take(5)->get();
        
        return view('home', [
            'latestArticles' => $latestArticles
        ]);
    }
}
