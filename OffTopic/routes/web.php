<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Auth::routes();

// Posts Controller
Route::get('/blog', 'PostsController@index');
Route::get('/blog/create', 'PostsController@create');
Route::get('/blog/{id}', 'PostsController@show');
Route::get('/blog/{id}/edit', 'PostsController@edit');

Route::delete('/blog/{id}/delete', 'PostsController@destroy');
Route::post('/blog/store', 'PostsController@store')->name('store');
Route::put('/blog/{id}/update', 'PostsController@update')->name('update');

// Posts Comments Controller
Route::post('/blog/{id}/comment/create', 'PostCommentController@store');
Route::delete('/blog/{postId}/comment/{commentId}/delete', 'PostCommentController@destroy');
// AJAX for comment edit & update
Route::get('/comment/{id}/edit', 'PostCommentController@edit');
Route::put('/comment/update', 'PostCommentController@update');