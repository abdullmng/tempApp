<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"=> "Abdullahi Muhammad",
            "username" => "abdullmng",
            "email"=> "abdullmng@gmail.com",
            "password" => "12345"
        ]);
    }
}
