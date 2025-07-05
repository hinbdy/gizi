<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $articles = Article::latest()->get(); // Mengambil semua artikel
        $totalArticles = Article::count();    // Total semua artikel

        $articlePerMonth = DB::table('articles')
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupByRaw('MONTH(created_at)')
        ->orderByRaw('MONTH(created_at)')
        ->get();

        // return view('admin.dashboard', [
        //     'user' => $user,
        //     'articles' => $articles,
        //     'totalArticles' => $totalArticles,
        //     'articlePerMonth' => $articlePerMonth
        // ]);
        return view('admin.dashboard', compact('user', 'articles', 'totalArticles', 'articlePerMonth'));
    }
}
