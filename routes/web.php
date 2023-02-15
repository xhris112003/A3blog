<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;


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

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::post('/', [ArticleController::class, 'store']);
Route::resource('posts', 'PostController');
Route::resource('comments', 'CommentController');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('articles/{article}/comments', 'CommentController@store');
Route::get('/profile', 'App\Http\Controllers\ProfileController@showProfile');
Route::get('login', 'App\Http\Controllers\AuthController@showLogin');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');


Auth::routes();

