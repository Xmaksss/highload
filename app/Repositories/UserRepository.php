<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    /**
     * @var User[]
     */
    protected static $users = [];


    public static function getUserById(int $id)
    {
        if (!in_array($id, array_keys(self::$users))) {
            self::$users[$id] = User::query()->find($id);
        }

        return self::$users[$id];
    }
}