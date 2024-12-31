<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
        "name"=> "Hind", 
        "email"=>"hind@gmail.com",
        "Password"=> Hash::make("1234546789")
        ]);
    }
}
