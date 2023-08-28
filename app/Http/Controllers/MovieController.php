<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
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
        return $tmdb;
    }
}
