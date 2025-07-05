<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    // Menampilkan halaman About
    public function index()
    {
        return view('about.index');
    }
}
