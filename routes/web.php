<?php

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

/*
 *  $threads->each(function($thread){factory('App\Reply', 10)->create(['thread_id' =>$thread->id]);});

 */

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

//Route::resource('/threads', 'ThreadsController');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');

Route::post('/threads', 'ThreadsController@store');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::delete('/replies/{reply}', 'RepliesController@destroy');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');



