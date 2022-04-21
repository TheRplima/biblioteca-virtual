<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'App\Http\Controllers\BookController@index');
Route::get('/home', ['as' => 'home', 'uses' => 'App\Http\Controllers\BookController@index']);

//authentication
// Route::resource('auth', 'Auth\AuthController');
// Route::resource('password', 'Auth\PasswordController');
Route::group(['prefix' => 'auth'], function () {
  Auth::routes();
});

// check for logged in user
Route::middleware(['auth'])->group(function () {
  // show new book form
  Route::get('new-book', 'App\Http\Controllers\BookController@create');
  // save new book
  Route::post('new-book', 'App\Http\Controllers\BookController@store');
  // edit book form
  Route::get('edit/{slug}', 'App\Http\Controllers\BookController@edit');
  // update book
  Route::post('update', 'App\Http\Controllers\BookController@update');
  // delete book
  Route::get('delete/{id}', 'App\Http\Controllers\BookController@destroy');
  // display user's all books
  Route::get('my-all-books', 'App\Http\Controllers\UserController@user_books_all');
  // display user's drafts
  Route::get('my-drafts', 'App\Http\Controllers\UserController@user_books_draft');
});

//users profile
Route::get('user/{id}', 'App\Http\Controllers\UserController@profile')->where('id', '[0-9]+');
// display list of books
Route::get('user/{id}/books', 'App\Http\Controllers\UserController@user_books')->where('id', '[0-9]+');
// display single book
Route::get('/{slug}', ['as' => 'book', 'uses' => 'App\Http\Controllers\BookController@show'])->where('slug', '[A-Za-z0-9-_]+');
