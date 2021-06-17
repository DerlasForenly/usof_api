<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'login' => 'Derlas',
            'name' => 'Derlas Forenly',
            'password' => Hash::make('minecraft'),
            'email' => 'tany.tany283@gmail.com',
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'login' => "vponomaren",
            'name' => 'Vladiiimer',
            'password' => Hash::make('111111'),
            'email' => 'vladimer@test.test',
            'role' => 'user'
        ]);

        DB::table('users')->insert([
            'login' => 'AlexRazor',
            'name' => 'Alexander Not Lucashenko',
            'password' => Hash::make('111111'),
            'email' => 'alex@test.test',
            'role' => 'user'
        ]);

        DB::table('users')->insert([
            'login' => '_PuSsY_dEsTrOyEr_',
            'name' => 'Anonimus Name',
            'password' => Hash::make('111111'),
            'email' => 'anonimus@test.test',
            'role' => 'user'
        ]);

        DB::table('users')->insert([
            'login' => 'Goirno',
            'name' => 'Giorno Giovanna',
            'password' => Hash::make('111111'),
            'email' => 'user4@test.test',
            'role' => 'user'
        ]);
    }
}
