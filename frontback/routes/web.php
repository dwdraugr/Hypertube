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

Auth::routes(['verify' => true]);

// OAuth from Github
Route::get('login/github', 'OAuth\GithubController@redirectToProvider');
Route::get('login/github/callback', 'OAuth\GithubController@handleProviderCallback');
// OAuth from 42 Ecole
Route::get('login/ecole', 'OAuth\EcoleController@redirectToProvider');
Route::get('login/ecole/callback', 'OAuth\EcoleController@handleProviderCallback');

Route::get('/res', 'HomeController@show');

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

