<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Http\Resources\ArticleItemResource;
use App\Http\Resources\ArticleListResource;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    private $articleRepository;


    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 24);
        $offset = $request->input('offset', 0);

        $articles = $this->articleRepository
            ->getPublishedArticlesQuery()
            ->limit($limit)
            ->offset($offset)
            ->get();

        return response()->json(ArticleListResource::collection($articles));
    }

    public function show(Article $article)
    {
        return response()->json(new ArticleItemResource($article));
    }
}
