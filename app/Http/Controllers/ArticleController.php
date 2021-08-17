<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = Article::with(array('tags' => function($q) {
            $q->select('article_id', 'tag');
        }))->get();
        return response()->json($articles, 200);
    }

    public function store(Request $request)
    {
        return $this->articleService->store($request);
    }

    public function update(Request $request, $id)
    {
        return $this->articleService->update($request, $id);
    }

    public function delete($id)
    {
        $article = Article::find($id);
        $article->delete();

        return response()->json('Article is deleted successfully', 200);
    }
}
