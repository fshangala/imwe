<?php

use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('movies')->controller(MovieController::class)->name("movies.")->group(function(){
    Route::get('/', 'list')->name("list");
    Route::post('/create', 'create')->name("create");
    Route::prefix("{id}")->name("single.")->group(function(){
        Route::get('/','show')->name("show");
        Route::post('/update','update')->name("update");
        Route::post('/upload','upload')->name("upload");
        Route::post('/upload_video','upload_video')->name("upload_video");
        Route::post('/upload_poster','upload_poster')->name("upload_poster");
        Route::delete('/delete','delete')->name('delete');
    });
    Route::prefix("tmdb")->name("tmdb.")->group(function(){
        Route::post('/search','tmdb_search')->name("search");
        Route::post('/create','tmdb_create')->name("create");
    });
});