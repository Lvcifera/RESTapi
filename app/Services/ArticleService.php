<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleService
{
    public function store(Request $request)
    {
        $tags = explode(',', preg_replace('/\s+/', '', $request->get('tags')));
        foreach ($tags as $key => $tag) {
            if (Tag::where('tag', $tag)->first()) {
                return response()->json('Tags is not unique in database', 200);
            }
        }
        if (count(array_unique($tags)) != count($tags)) {
            return response()->json('Tags is not unique in this article', 200);
        }

        $article = Article::create($request->all());
        if ($article->wasRecentlyCreated) {
            foreach ($tags as $tag) {
                Tag::create([
                    'article_id' => $article->id,
                    'tag' => $tag,
                ]);
            }
        }

        return response()->json($article, 200);
    }

    public function update(Request $request, $id)
    {
        $article = Article::with('tags')->find($id);
        $article->update($request->all());

        return response()->json($article, 200);
    }
}
