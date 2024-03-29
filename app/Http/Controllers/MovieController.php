<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\Movie;
use CodeBugLab\Tmdb\Facades\Tmdb;

class MovieController extends Controller
{
    public function list() {
        return MovieResource::collection(Movie::paginate());
    }

    public function show($id) {
        return new MovieResource(Movie::findOrFail($id));
    }
    public function create(Request $request) {
        $request->validate([
            'title' => 'required|unique:movies',
            'overview' => 'required',
            'runtime'=>'required',
            'language'=>'required'
        ]);

        $movie = Movie::create($request->all());
        return new MovieResource($movie);
    }
    public function update(Request $request, $id) {
        $movie = Movie::where('id',$id)->update($request->all());
        return $movie;
    }
    public function delete($id) {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return new MovieResource($movie);
    }
    public function upload_video(Request $request, $id) {
        $request->validate([
            "movie"=>"required"
        ]);

        $movie = Movie::findOrFail($id);
        $path = $request->file('movie')->store("public/movies/{$movie->id}/videos");
        $movie->video_path = $path;
        $movie->save();
        return new MovieResource($movie);
    }
    public function upload_poster(Request $request, $id) {
        $request->validate([
            "poster"=>"required"
        ]);

        $movie = Movie::findOrFail($id);
        $path = $request->file('poster')->store("public/movies/{$movie->id}/posters");
        $movie->poster_path = $path;
        $movie->save();
        return new MovieResource($movie);
    }
    public function add_genres(Request $request, $id) {
        $validated = $request->validate([
            "genre_ids"=>"required"
        ]);

        $movie = Movie::findOrFail($id);
        $movie_genre_ids = [];
        foreach($movie->genres as $movie_genre) {
            array_push($movie_genre_ids,$movie_genre->id);
        }
        foreach($validated['genre_ids'] as $genre_id) {
            if(!in_array($genre_id,$movie_genre_ids)){
                $movie->genres()->attach($genre_id);
            }
        }
        $movie->fresh();
        return new MovieResource($movie);
    }
    public function remove_genres(Request $request, $id) {
        $validated = $request->validate([
            "genre_ids"=>"required"
        ]);

        $movie = Movie::findOrFail($id);
        $movie_genre_ids = [];
        foreach($movie->genres as $movie_genre) {
            array_push($movie_genre_ids,$movie_genre->id);
        }
        foreach($validated['genre_ids'] as $genre_id) {
            if(in_array($genre_id,$movie_genre_ids)){
                $movie->genres()->detach($genre_id);
            }
        }
        $movie->fresh();
        return new MovieResource($movie);
    }
    public function tmdb_search(Request $request) {
        $validated = $request->validate([
            "query"=>"required"
        ]);
        $tmdb = Tmdb::search()->multi()->query($validated["query"])->get();
        return $tmdb;
    }
    public function tmdb_create(Request $request) {
        $validated = $request->validate([
            "tmdb_id"=>"required"
        ]);
        $tmdb = Tmdb::movies()->details($validated["tmdb_id"])->get();
        $movie = Movie::where('tmdb_id',$validated['tmdb_id'])->first();
        if($movie){
            $movie->title = $tmdb["title"];
            $movie->overview = $tmdb["overview"];
            $movie->runtime = $tmdb["runtime"];
            $movie->language = $tmdb["original_language"];
            $movie->homepage = $tmdb["homepage"];
            $movie->tmdb_id = $tmdb["id"];
            $movie->imdb_id = $tmdb["imdb_id"];
            $movie->release_date = $tmdb["release_date"];
        } else {
            $movie = new Movie();
            $movie->title = $tmdb["title"];
            $movie->overview = $tmdb["overview"];
            $movie->runtime = $tmdb["runtime"];
            $movie->language = $tmdb["original_language"];
            $movie->homepage = $tmdb["homepage"];
            $movie->tmdb_id = $tmdb["id"];
            $movie->imdb_id = $tmdb["imdb_id"];
            $movie->release_date = $tmdb["release_date"];
        }
        $movie->save();
        foreach($tmdb['genres'] as $tmdb_genre){
            $genre = Genre::firstOrCreate(['name'=>$tmdb_genre['name']],['name'=>$tmdb_genre['name']]);
            $exists = false;
            foreach($movie->genres as $movie_genre){
                if($movie_genre->name == $tmdb_genre['name']){
                    $exists = true;
                    break;
                }
            }
            if(!$exists){
                $movie->genres()->attach($genre->id);
            }
        }
        return new MovieResource($movie);
    }
    public function tmdb_get($tmdb_id) {
        $tmdb = Tmdb::movies()->details($tmdb_id)->get();
        return $tmdb;
    }
}
