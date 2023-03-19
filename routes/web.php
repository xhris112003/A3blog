<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
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
Route::get('/myarticles', [ArticleController::class, 'myarticles'])->name('myarticles');
Route::post('/', [ArticleController::class, 'store']);
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::post('/articles/{article}/tags', 'App\Http\Controllers\TagController@addTag')->name('article.addTag');
Route::get('/articles/{id}', 'App\Http\Controllers\ArticleController@show')->name('article.show');

Route::get('/search', 'App\Http\Controllers\TagController@searchByTag')->name('article.searchByTag');

Route::put('/users/{id}', 'App\Http\Controllers\UserController@update')->name('users.update');
Route::put('/article/{id}', 'App\Http\Controllers\ArticleController@update')->name('article.update');

Route::post('/logout', [ArticleController::class, 'logout'])->name('article.logout');

Route::resource('posts', 'PostController');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::post('login', 'Auth\LoginController@login');
Route::post('articles/{article}/comments', 'CommentController@store');
Route::get('/profile', 'App\Http\Controllers\ProfileController@showProfile')->name('profile');
Route::get('login', 'App\Http\Controllers\AuthController@showLogin');
Route::post('/profile/update', 'App\Http\Controllers\ProfileController@store')->name('profile.update');
Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/administration','App\Http\Controllers\AdministrationController@showUsers')->name('administration');
Route::get('/administration/articles','App\Http\Controllers\AdminArticleController@showArticle')->name('AdminArticles');

Route::post('/administration/addAdmin','App\Http\Controllers\AdministrationController@addAdmin')->name('addAdmin');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');
Route::delete('/users/{users}', [UserController::class, 'destroy'])->name('users.destroy');


Auth::routes();

