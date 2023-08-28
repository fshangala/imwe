<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Movie::truncate();
        $fake = \Faker\Factory::create();
        for ($i = 0; $i < 5; $i++){
            Movie::create([
                "title"=>$fake->sentence(),
                "overview"=>$fake->paragraph(),
                "runtime"=>$fake->numberBetween(80,180),
                "language"=>$fake->word(),
                "homepage"=>$fake->url()
            ]);
        }
    }
}
