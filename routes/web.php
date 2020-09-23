<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TriviaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/players', [PlayerController::class,'index']);
Route::get('/players/{id}', [PlayerController::class,'show']);
Route::post('/players', [PlayerController::class,'store']);
Route::post('/players/{id}/answers', [PlayerController::class,'answer']);
Route::delete('/players/{id}', [PlayerController::class,'delete']);
Route::delete('/players/{id}/answers', [PlayerController::class,'resetAnswers']);

Route::get('/trivia', [TriviaController::class,'index']);
