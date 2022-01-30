<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Profile;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::factory(10)->create();

        foreach ($users as $user) {
            $r50 = rand(0, 1);
            if ($r50 == 1) {
                $user->profile()->save(Profile::factory()->make());
            }
            $tweets = Tweet::factory(rand(1, 10))->create(['user_id' => $user->id]);
            foreach ($tweets as $tweet) {
                $r10 = rand(0, 1);
                if ($r10 == 1) {
                    $tweet->comments()->saveMany(Comment::factory(rand(1, 10))->make(['user_id' => $user->id]));
                }
            }

            $users2follow = User::where('id', '!=', $user->id)->inRandomOrder()->take(rand(1, 8))->get()->pluck('id');
            $tweets2like = Tweet::where('user_id', '!=', $user->id)->inRandomOrder()->take(rand(1, 20))->get()->pluck('id');

            $user->following()->sync($users2follow);
            $user->likes()->sync($tweets2like);
        }
    }
}
