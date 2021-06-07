<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LikeSeeder extends Seeder
{
    public function run()
    {
        DB::table('likes')->insert([
            'user_id' => 1,
            'post_id' => 1,
            'like' => 1,
            'dislike' => 0
        ]);

        DB::table('likes')->insert([
            'user_id' => 1,
            'post_id' => 2,
            'like' => 1,
            'dislike' => 0
        ]);

        DB::table('likes')->insert([
            'user_id' => 1,
            'post_id' => 3,
            'like' => 1,
            'dislike' => 0
        ]);

        DB::table('likes')->insert([
            'user_id' => 1,
            'post_id' => 4,
            'like' => 1,
            'dislike' => 0
        ]);

        DB::table('likes')->insert([
            'user_id' => 1,
            'post_id' => 5,
            'like' => 1,
            'dislike' => 0
        ]);
    }
}
