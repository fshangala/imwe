<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MovieTest extends TestCase
{
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_movies()
    {
        $response = $this->get('/api/movies');
        $response->assertStatus(200);
    }
    public function test_create()
    {
        $fake = \Faker\Factory::create();
        $response = $this->post('/api/movies/create',[
            "title"=>$fake->title(),
            "description"=>$fake->sentence()
        ]);
        $response->assertStatus(201);
    }
    public function test_upload() {
        $file = UploadedFile::fake()->create("movie.mp4",2000,"video/mp4");
        
        $response = $this->post('/api/movies/1/upload',[
            "movie"=>$file
        ]);
        $response->assertStatus(200);
    }
    public function test_create_by_tmdbid() {
        $response = $this->get('/api/movies/imdb');
        $response->assertStatus(200);
        echo $response->content();
    }
}
