<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $fake = \Faker\Factory::create();
        $password = Hash::make("123456");
        User::create([
            "name"=>"Admin",
            "email"=>"admin@localhost",
            "password"=>$password
        ]);

        for ($i = 0; $i < 5; $i++){
            User::create([
                "name"=>$fake->name(),
                "email"=>$fake->email(),
                "password"=>$password
            ]);
        }
    }
}
