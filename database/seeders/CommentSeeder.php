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
            'post_id' => 1,
            'content' => 'It is my own comment, thx for attention',
        ]);

        DB::table('comments')->insert([
            'user_id' => 2,
            'post_id' => 2,
            'content' => 'Меня взломали, я не мог такое сказать',
        ]);

        DB::table('comments')->insert([
            'user_id' => 2,
            'post_id' => 3,
            'content' => 'Ммммммм....',
        ]);

        DB::table('comments')->insert([
            'user_id' => 1,
            'post_id' => 3,
            'content' => 'Ммммм....',
        ]);

        DB::table('comments')->insert([
            'user_id' => 1,
            'post_id' => 4,
            'content' => 'ok',
        ]);

        DB::table('comments')->insert([
            'user_id' => 1,
            'post_id' => 5,
            'content' => 'Ok, i will do it',
        ]);
    }
}
