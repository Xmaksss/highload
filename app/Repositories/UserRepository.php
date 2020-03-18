<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    /**
     * @var User[]
     */
    protected static $users = [];


    public static function getUserById(int $id, $raw = false)
    {
        if (!in_array($id, array_keys(self::$users))) {
            self::$users[$id] = $raw ? DB::table('users')->find($id) : User::query()->find($id);
        }

        return self::$users[$id];
    }
}