<?php

namespace App\Http\Resources;

use App\Article;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ArticleListResource
 * @mixin Article
 * @package App\Http\Resources
 */
class ArticleListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'published_at' => $this->published_at,
            'preview' => $this->preview,
            'last_comment' => new CommentItemResource($this->last_comment)
        ];
    }
}
