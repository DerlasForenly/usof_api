<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run()
    {
        DB::table('posts')->insert([
            'title' => 'Welcome',
            'content' => 'This is first post here',
            'categories' => '[]',
            'user_id' => 1
        ]);

        DB::table('posts')->insert([
            'title' => 'Test post 1',
            'content' => 'Test content 1',
            'categories' => '[1]',
            'user_id' => 2
        ]);

        DB::table('posts')->insert([
            'title' => 'Test post 2',
            'content' => 'Test content 2',
            'categories' => '[1, 3]',
            'user_id' => 3
        ]);

        DB::table('posts')->insert([
            'title' => 'Test post 3',
            'content' => 'Test content 3',
            'categories' => '[1, 3, 4]',
            'user_id' => 2
        ]);

        DB::table('posts')->insert([
            'title' => 'Test post 4',
            'content' => 'Test content 5',
            'categories' => '[2, 1]',
            'user_id' => 2
        ]);
    }
}
