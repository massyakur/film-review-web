<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

# Route Auth JWT
Route::group([
    'prefix' => 'auth',
    'namespace' => 'Auth'
], function () {
    Route::post('register', 'RegisterController')->name('auth.register');
    Route::post('regenerate-otp-code', 'RegenerateOtpCodeController')->name('auth.regenerate_otp_code');
    Route::post('verification', 'VerificationController')->name('auth.verification');
    Route::post('update-password', 'UpdatePasswordController')->name('auth.update_password');
    Route::post('login', 'LoginController')->name('auth.login');
});

# Route Resource Genre
# Method (GET) Search Resource by name
Route::apiResource('genre', 'GenreController');
Route::get('/genre/search/{name}', 'GenreController@search')->name('genre_search.name');

# Route Resource Profile
Route::apiResource('profile', 'ProfileController');

# Route Resource Gen Film
Route::apiResource('gen-film', 'GenreFilmController');
Route::get('/genfilm-by-genre-id', 'GenreFilmController@getDataByGenreId')->name('genfilm.by_genre_id');
Route::get('/genfilm-by-film-id', 'GenreFilmController@getDataByFilmId')->name('genfilm.by_film_id');

# Route Resource User
# Method (GET) Search Resource by name
Route::apiResource('user', 'UserController');
Route::get('/user/search/{name}', 'UserController@search')->name('user_search.name');

# Route Resource Film
# Method (GET) Search Resource by name
Route::apiResource('film', 'FilmController');
Route::get('/film/search/{name}', 'FilmController@search')->name('film_search.name');

# Route Resource Cast
# Method (GET) Search Resource by name
Route::apiResource('cast', 'CastController');
Route::get('/cast/search/{name}', 'CastController@search')->name('cast_search.name');

# Route Resource Peran
# Method (GET) Search Resource by name
Route::apiResource('peran', 'PeranController');
Route::get('/peran-by-id', 'PeranController@getDataById')->name('peran.by_id');
Route::get('/peran/search/{name}', 'PeranController@search')->name('peran_search.name');

# Route Resource Feedback
Route::apiResource('feedback', 'FeedbackController');
Route::get('/feedback-by-id', 'FeedbackController@getDataById')->name('feedback.by_id');
