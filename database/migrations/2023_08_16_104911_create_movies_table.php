<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("overview");
            $table->integer("runtime");
            $table->string("language");
            $table->string("homepage")->nullable();
            $table->bigInteger("tmdb_id")->nullable();
            $table->bigInteger("imdb_id")->nullable();
            $table->string("poster_path")->nullable();
            $table->string("video_path")->nullable();
            $table->date("release_date")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
