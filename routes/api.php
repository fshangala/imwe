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
Route::get('/movies', [MovieController::class,'index']);
Route::post('/movies/create', [MovieController::class,'create']);
Route::post('/movies/{id}/upload',[MovieController::class,'upload']);
Route::get('/movies/imdb',[MovieController::class,'create_by_tmdbid']);