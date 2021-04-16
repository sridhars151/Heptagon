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
    return view('welcome');
});

Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware(['auth'])->name('dashboard');
Route::get('/articles', 'App\Http\Controllers\ArticlesController@index')->middleware(['auth'])->name('article');
Route::get('/articles/add', 'App\Http\Controllers\ArticlesController@addForm')->middleware(['auth'])->name('addform');
Route::post('/articles/add', 'App\Http\Controllers\ArticlesController@store')->middleware(['auth'])->name('addarticle');
Route::get('/articles/view/{id}', 'App\Http\Controllers\ArticlesController@viewArticle');
Route::get('/articles/add/{id}', 'App\Http\Controllers\ArticlesController@addForm');
Route::get('/articles/delete/{id}', 'App\Http\Controllers\ArticlesController@deleteArticle');
Route::get('/articles/approve/{id}', 'App\Http\Controllers\ArticlesController@approveArticle');

require __DIR__.'/auth.php';
