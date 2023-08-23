<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use CodeBugLab\Tmdb\Facades\Tmdb;

class MovieController extends Controller
{
    public function index() {
        return Movie::all();
    }

    public function show($id) {
        return Movie::find($id);
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'title' => 'required|unique:movies',
            'description' => 'required'
        ]);

        $movie = new Movie();
        $movie->title = $validated["title"];
        $movie->description = $validated["description"];
        $movie->save();

        return $movie;
    }
    public function update(Request $request) {
        return 200;
    }
    public function delete($id) {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return response()->json(null,204);
    }
    public function upload(Request $request, $id) {
        $validated = $request->validate([
            "movie"=>"required"
        ]);

        $path = $request->file('movie')->store('public/movies');

        $movie = Movie::findOrFail($id);
        $movie->path = $path;
        $movie->save();

        return $movie;
    }
    public function create_by_tmdbid() {
        $tmdb = Tmdb::genres()->movieList()->get();
        return $tmdb;
    }

}
