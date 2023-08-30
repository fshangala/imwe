<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "title"=>$this->title,
            "overview"=>$this->overview,
            "runtime"=>$this->runtime,
            "language"=>$this->language,
            "homepage"=>$this->homepage,
            "tmdb_id"=>$this->tmdb_id,
            "imdb_id"=>$this->imdb_id,
            "poster_path"=>$this->poster_path,
            "video_path"=>$this->video_path,
            "release_date"=>$this->release_date,
            'genres'=> GenreResource::collection($this->genres)
        ];
    }
}
