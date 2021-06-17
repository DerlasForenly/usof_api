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
            'title' => 'Off top',
            'description' => 'It means something like: "for real", "seriously" or "I swear".
            Also can be used to mean "right away".',
        ]);

        DB::table('categories')->insert([
            'title' => 'C++',
            'description' => "A programming language for Real Men.
            Most languages try to provide a simplified way to solve specific problems well.",
        ]);

        DB::table('categories')->insert([
            'title' => 'Javascript',
            'description' => 'A powerful, object-based,
            interpreted scripting language, created by
            Brendan Eich, most commonly embedded
            directly into HTML web pages to manage
            client-side interaction.',
        ]);

        DB::table('categories')->insert([
            'title' => 'Poland',
            'description' => 'The first country to defeat the Soviet Union in war.
            The country that defeated the Teutonic knights,
            ending German supremacy for hundreds of years.',
        ]);

        DB::table('categories')->insert([
            'title' => 'Ukraine',
            'description' => 'Ukraine most often erroneously called
            "The" Ukraine is a country in Eastern Europe. Ukraine is
            not Russia & Russia is not Ukraine.',
        ]);

        DB::table('categories')->insert([
            'title' => 'Anime',
            'description' => 'Japanese animation drawn in the same
            style as manga just animated. Often messed up by America.',
        ]);

        DB::table('categories')->insert([
            'title' => 'Memes',
            'description' => 'The cure of depression.',
        ]);
    }
}
