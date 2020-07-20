<?php

//use App\Http\Controllers\UserController;
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

Route::get('/locale', function () {
    return require "../resources/lang/". App::getLocale() ."/front.php";
});

Auth::routes(['verify' => true]);

Route::resource('users', UserController::class)->only([
    'show', 'edit', 'update',
])->middleware('verified');

// OAuth from Github
Route::get('login/github', 'OAuth\GithubController@redirectToProvider');
Route::get('login/github/callback', 'OAuth\GithubController@handleProviderCallback');
// OAuth from 42 Ecole
Route::get('login/ecole', 'OAuth\EcoleController@redirectToProvider');
Route::get('login/ecole/callback', 'OAuth\EcoleController@handleProviderCallback');
//DEPRECATED
Route::get('/search', 'SearchController@searchElems')->middleware('verified');

//new progressive system
Route::get('/download', 'TorrentController@startDownload')->middleware('verified');
Route::get('/api/latest', 'YtsController@index')->middleware('verified');
Route::get('/api/{id}', 'YtsController@show')->middleware('verified');

Route::get('/api/comment/{video}', 'CommentController@index')->middleware('verified');
Route::post('/api/comment/', 'CommentController@store')->middleware('verified');

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
