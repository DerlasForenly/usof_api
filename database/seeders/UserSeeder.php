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
            'password' => Hash::make('dNRhmRZ'),
            'email' => 'tany.tany283@gmail.com',
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'login' => 'User1',
            'name' => 'First Name',
            'password' => Hash::make('111111'),
            'email' => 'user1@test.test',
            'role' => 'user'
        ]);

        DB::table('users')->insert([
            'login' => 'User2',
            'name' => 'First Name',
            'password' => Hash::make('111111'),
            'email' => 'user2@test.test',
            'role' => 'user'
        ]);

        DB::table('users')->insert([
            'login' => 'User3',
            'name' => 'First Name',
            'password' => Hash::make('111111'),
            'email' => 'user3@test.test',
            'role' => 'user'
        ]);

        DB::table('users')->insert([
            'login' => 'User4',
            'name' => 'First Name',
            'password' => Hash::make('111111'),
            'email' => 'user4@test.test',
            'role' => 'user'
        ]);
    }
}
