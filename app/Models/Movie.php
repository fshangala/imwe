<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "overview",
        "runtime",
        "language",
        "homepage",
        "tmdb_id",
        "imdb_id",
        "poster_path",
        "video_path",
        'trailer_url',
        "release_date",
    ];
}
