<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    public function run()
    {
        DB::table('comments')->insert([
            'user_id' => 1,
            'login' => 'Derlas',
            'post_id' => 1,
            'content' => 'It is my first comment',
        ]);

        DB::table('comments')->insert([
            'user_id' => 2,
            'login' => 'User1',
            'post_id' => 2,
            'content' => 'test comment 1',
        ]);

        DB::table('comments')->insert([
            'user_id' => 2,
            'login' => 'User1',
            'post_id' => 2,
            'content' => 'test comment 2',
        ]);

        DB::table('comments')->insert([
            'user_id' => 3,
            'login' => 'User2',
            'post_id' => 2,
            'content' => 'test comment 4',
        ]);

        DB::table('comments')->insert([
            'user_id' => 3,
            'login' => 'User2',
            'post_id' => 3,
            'content' => 'test comment 5',
        ]);
    }
}
