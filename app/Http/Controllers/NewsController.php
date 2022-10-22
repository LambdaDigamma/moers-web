<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->orderByDesc('published_at')
            ->paginate(9);

        SEOTools::setTitle('Neuigkeiten');

        return view('news.index', ['posts' => $posts]);
    }
}
