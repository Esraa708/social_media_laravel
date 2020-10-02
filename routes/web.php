<?php

use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth'])->group(function() {  
Route::resource('friends', 'FriendController', [
    'name' =>   [
        'index' => 'friends',
        'create' => 'freinds.create'
    ]
])->except([
    'update'
]);
Route::resource('post', 'PostController', [])->except(['edit','create']);
Route::resource('comment', 'CommentController', [])->except(['edit','show', 'create', 'index']);
Route::get('/friendposts', 'PostController@friendPosts')->name('friendposts');
Route::get('/index','IndexController@create')->name('indexpage');
Route::get('/post/comments/{id}', 'CommentController@postComments')->name('postcomments');
Route::get('/comments/replies/{id}', 'CommentController@commentReplies')->name('commentreplies');
Route::get('/home', 'HomeController@index')->name('home');
});