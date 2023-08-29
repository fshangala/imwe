<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_genre_index()
    {
        $response = $this->get(route('genres.index'));
        $response->assertStatus(200);
        echo var_dump($response->json());
    }
    public function test_genre_store()
    {
        $fake = \Faker\Factory::create();
        $response = $this->post(route('genres.store'),[
            'name'=>$fake->word()
        ]);
        $response->assertStatus(201);
        echo var_dump($response->json());
    }
    public function test_genre_show()
    {
        $response = $this->get(route('genres.single.show',['genre'=>1]));
        $response->assertStatus(200);
        echo var_dump($response->json());
    }
    public function test_genre_update()
    {
        $fake = \Faker\Factory::create();
        $response = $this->post(route('genres.single.update',['genre'=>1]),[
            'name'=>$fake->word()
        ]);
        $response->assertStatus(200);
        echo var_dump($response->json());
    }
    public function test_genre_delete()
    {
        $response = $this->delete(route("genres.single.delete",['genre'=>3]));
        $response->assertStatus(200);
        echo var_dump($response->json());
    }
}
