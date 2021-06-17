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
            'content' => 'This is first post here created with PostSeeder',
            'categories' => '[1]',
            'user_id' => 1
        ]);

        DB::table('posts')->insert([
            'title' => 'Dota is a shit',
            'content' => 'Я все сказал!',
            'categories' => '[1, 4]',
            'user_id' => 2
        ]);

        DB::table('posts')->insert([
            'title' => 'Ukraine',
            'content' => 'Смажена картошка',
            'categories' => '[1, 5]',
            'user_id' => 3
        ]);

        DB::table('posts')->insert([
            'title' => "Discussion about Poland's role in meme-industry",
            'content' => 'I think it is really important',
            'categories' => '[1, 4, 6]',
            'user_id' => 4
        ]);

        DB::table('posts')->insert([
            'title' => 'Please, delete me',
            'content' => "I exist only for deleting, just do it!",
            'categories' => '[1]',
            'user_id' => 5
        ]);
    }
}
