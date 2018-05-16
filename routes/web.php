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



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>['web', 'auth']], function(){
Route::get('/', function () {
      $posts = App\Post::all();
      return view('welcome')->withPosts($posts);
  });
Route::post('/posts', 'PostsController@store')->name('posts.store');
Route::post('/posts/like', 'LikeController@postlike')->name('postlike');
Route::post('comment/{post}', 'CommentController@postComment')->name('addComment');

});
