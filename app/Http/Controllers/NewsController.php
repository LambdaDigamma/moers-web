<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOTools;
use Modules\News\Models\Post;

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
