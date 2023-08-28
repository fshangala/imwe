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
    public function test_list()
    {
        $response = $this->get(route("movies.list"));
        echo var_dump($response->json());
        $response->assertStatus(200);
    }
    public function test_show() {
        $response = $this->get(route("movies.single.show",["id"=>1]));
        echo var_dump($response->json());
        $response->assertStatus(200);
    }
    public function test_create()
    {
        $fake = \Faker\Factory::create();
        $response = $this->post(route("movies.create"),[
            "title"=>$fake->sentence(),
            "overview"=>$fake->paragraph(),
            "runtime"=>$fake->numberBetween(80,180),
            "language"=>$fake->word(),
            "homepage"=>$fake->url()
        ]);
        $response->assertStatus(201);
        echo var_dump($response->json());
    }
    public function test_update()
    {
        $fake = \Faker\Factory::create();
        $response = $this->post(route("movies.single.update",['id'=>1]),[
            "title"=>$fake->sentence(),
            "overview"=>$fake->paragraph(),
            "runtime"=>$fake->numberBetween(80,180),
            "language"=>$fake->word(),
            "homepage"=>$fake->url()
        ]);
        $response->assertStatus(200);
        echo var_dump($response->json());
    }
    public function test_delete()
    {
        $fake = \Faker\Factory::create();
        $response = $this->delete(route("movies.single.delete",['id'=>3]));
        $response->assertStatus(200);
        echo var_dump($response->json());
    }
    public function test_upload_video() {
        $file = UploadedFile::fake()->create("movie.mp4",2000,"video/mp4");
        
        $response = $this->post(route("movies.single.upload_video",['id'=>1]),[
            "movie"=>$file
        ]);
        $response->assertStatus(200);
        echo var_dump($response->json());
    }
    public function test_upload_poster() {
        $file = UploadedFile::fake()->create("poster.jpg");
        
        $response = $this->post(route("movies.single.upload_poster",['id'=>1]),[
            "poster"=>$file
        ]);
        $response->assertStatus(200);
        echo var_dump($response->json());
    }
    public function test_tmdb_search() {
        $response = $this->post(route("movies.tmdb.search"),[
            "query"=>"batman"
        ]);
        $response->assertStatus(200);
        echo var_dump($response->json());
    }
    public function test_tmdb_create() {
        $response = $this->post(route("movies.tmdb.create"),[
            "tmdb_id"=>"272"
        ]);
        $response->assertStatus(200);
        echo var_dump($response->json());
    }
}
