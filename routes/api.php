<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    
    Route::apiResource('/series',\App\Http\Controllers\Api\SeriesController::class); //Criando API
    
    Route::get('/series/{series}/seasons', function (\App\Models\Series $series) { //Buscando as temoradas da serie.
        return $series->seasons;
    });
    
    Route::get('/series/{series}/episodes', function (\App\Models\Series $series) { //Buscando os episodes da serie.
        return $series->episodes;
    });
    
    Route::patch('/episodes/{episode}', function(\App\Models\Episode $episode, Request $request) { //Assistindo EP
        $episode->watched = $request->watched;
        $episode->save();
    
        return $episode;
    });

});

Route::post('/login', function (Request $request) {
    $credentials = $request->only(['email','password']);
    if(\Illuminate\Support\Facades\Auth::attempt($credentials) === false) {
        return response()->json('Unauthorized', 401);
    }

    $user = \Illuminate\Support\Facades\Auth::user();
    $user->tokens()->delete();
    $token = $user->createToken('token',['series:delete']); //HAB:  passando habilidade de excluir serie apenas para esse usuario com este token com o ['series:delete']

    return response()->json($token->plainTextToken);
});
