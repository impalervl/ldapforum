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

Route::get('/', function () {
    $threads=App\Thread::paginate(15);

    return view('welcome',compact('threads'));
});

Route::get('/login', 'UserController@index');


Route::post('/login', 'UserController@login')->name('login');
Route::post('/logout', 'UserController@logout')->name('logout');
Route::resource('/thread','Forum\ThreadController');
Route::resource('comment','Forum\CommentController',['only'=>['update','destroy']]);
Route::post('comment/create/{thread}','Forum\CommentController@addThreadComment')->name('threadcomment.store');
Route::post('reply/create/{comment}','Forum\CommentController@addReplyComment')->name('replycomment.store');