<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('news.index', ['posts' => $posts]);
    }
}
