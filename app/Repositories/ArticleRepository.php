<?php

namespace App\Repositories;

use App\Article;

class ArticleRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getPublishedArticlesQuery()
    {
        return Article::published()
            ->orderBy('published_at', 'desc');
    }
}