<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @property-read integer $id
 * @property string $title
 * @property string $preview
 * @property string $body
 * @property string $published_at
 * @method static Builder published()
 * @package App
 */
class Article extends Model
{
    protected $fillable = [
        'title',
        'preview',
        'body',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];


    public function scopePublished(Builder $query)
    {
        return $query->whereDate('published_at', '<', now());
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        return $this->published()
                ->where('id', $value)
                ->first() ?? abort(404);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Comment[]
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getLastCommentAttribute()
    {
        return $this->comments()
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
