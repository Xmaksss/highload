<?php

namespace App\Repositories;

use App\Comment;
use Illuminate\Support\Collection;

class CommentRepository
{
    /**
     * @var Comment[]
     */
    protected static $comments = [];


    public static function getCommentById(int $id)
    {
        if (!in_array($id, array_keys(self::$comments))) {
            self::$comments[$id] = Comment::query()->find($id);
        }

        return self::$comments[$id];
    }

    public static function saveAll(Collection $collection)
    {
        foreach ($collection as $item) {
            self::save($item);
        }
    }

    public static function save(Comment $comment)
    {
        self::$comments[$comment->id] = $comment;
    }
}