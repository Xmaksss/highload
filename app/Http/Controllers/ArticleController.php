<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\ArticleListResource;
use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    private $articleRepository;


    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function indexStep1(Request $request)
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

    public function indexStep2(Request $request)
    {
        $limit = $request->input('limit', 24);
        $offset = $request->input('offset', 0);

        $articles = Article::published()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get();

        $data = [];

        foreach ($articles as $article) {
            $comment = $article->last_comment;
            $user = $comment->user;
            $data[] = [
                'id' => $article->id,
                'title' => $article->title,
                'published_at' => $article->published_at,
                'preview' => $article->preview,
                'last_comment' => [
                    'id' => $comment->id,
                    'body' => $comment->body,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                    ],
                ]
            ];
        }

        return response()->json($data);
    }

    public function indexStep3(Request $request)
    {
        $limit = $request->input('limit', 24);
        $offset = $request->input('offset', 0);

        $articles = Article::published()
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get();

        $data = [];

        foreach ($articles as $article) {
            $comment = DB::table('comments')
                ->where(['article_id' => $article->id])
                ->orderBy('created_at', 'desc')
                ->first();

            $user = UserRepository::getUserById($comment->user_id, true);
            $data[] = [
                'id' => $article->id,
                'title' => $article->title,
                'published_at' => $article->published_at,
                'preview' => $article->preview,
                'last_comment' => [
                    'id' => $comment->id,
                    'body' => $comment->body,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                    ],
                ]
            ];
        }

        return response()->json($data);
    }

    public function indexStep4(Request $request)
    {
        $limit = $request->input('limit', 24);
        $offset = $request->input('offset', 0);

        $data = Cache::remember("article.index[$offset:$limit]", 10, function() use ($offset, $limit) {
            $articles = Article::published()
                ->orderBy('published_at', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();

            $data = [];

            foreach ($articles as $article) {
                $comment = DB::table('comments')
                    ->where(['article_id' => $article->id])
                    ->orderBy('created_at', 'desc')
                    ->first();

                $user = UserRepository::getUserById($comment->user_id, true);
                $data[] = [
                    'id' => $article->id,
                    'title' => $article->title,
                    'published_at' => $article->published_at,
                    'preview' => $article->preview,
                    'last_comment' => [
                        'id' => $comment->id,
                        'body' => $comment->body,
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                        ],
                    ]
                ];
            }

            return $data;
        });

        return response()->json($data);
    }
}
