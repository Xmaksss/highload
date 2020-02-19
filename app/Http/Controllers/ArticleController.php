<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\ArticleItemResource;
use App\Http\Resources\ArticleListResource;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

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
            ->offset($offset);

//        dd($articles->toSql());

        $articles = $articles->get();

        return response()->json(ArticleListResource::collection($articles));
    }

    public function show(Article $article)
    {
        return response()->json(new ArticleItemResource($article));
    }
}
