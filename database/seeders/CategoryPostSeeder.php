<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategoryPostSeeder extends Seeder
{
    public function run()
    {
        DB::table('category_posts')->insert([
            'category_id' => 1,
            'post_id' => 1,
        ]);

        DB::table('category_posts')->insert([
            'category_id' => 1,
            'post_id' => 2,
        ]);

        DB::table('category_posts')->insert([
            'category_id' => 4,
            'post_id' => 2,
        ]);

        DB::table('category_posts')->insert([
            'category_id' => 1,
            'post_id' => 3,
        ]);

        DB::table('category_posts')->insert([
            'category_id' => 5,
            'post_id' => 3,
        ]);

        DB::table('category_posts')->insert([
            'category_id' => 1,
            'post_id' => 4,
        ]);

        DB::table('category_posts')->insert([
            'category_id' => 4,
            'post_id' => 4,
        ]);

        DB::table('category_posts')->insert([
            'category_id' => 6,
            'post_id' => 4,
        ]);

        DB::table('category_posts')->insert([
            'category_id' => 1,
            'post_id' => 5,
        ]);
    }
}
