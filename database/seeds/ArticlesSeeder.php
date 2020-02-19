<?php

use Illuminate\Database\Seeder;
use \App\Article;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::query()->get();

        factory(Article::class, 5000)->create()->each((function (Article $article) use ($users) {
            foreach (range(0, rand(5, 50)) as $i) {
                $article->comments()
                    ->save(factory(\App\Comment::class)->make([
                    'user_id' => $users->random(1)->first->id
                ]));
            }
        }));
    }
}
