<?php

namespace App;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'body',
    ];

    protected $appends = [
        'user'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function getUserAttribute()
    {
        return UserRepository::getUserById($this->user_id);
    }
}
