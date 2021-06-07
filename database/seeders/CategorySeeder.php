<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            'title' => 'Test1',
            'description' => 'Test category 1',
        ]);

        DB::table('categories')->insert([
            'title' => 'Test2',
            'description' => 'Test category 2',
        ]);

        DB::table('categories')->insert([
            'title' => 'Test3',
            'description' => 'Test category 3',
        ]);

        DB::table('categories')->insert([
            'title' => 'Test4',
            'description' => 'Test category 4',
        ]);

        DB::table('categories')->insert([
            'title' => 'Test5',
            'description' => 'Test category 5',
        ]);
    }
}
