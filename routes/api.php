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
Route::apiResource('genre', 'GenreController');
Route::get('/genre/search/{name}', 'GenreController@search');

# Route Resource Profile
Route::apiResource('profile', 'ProfileController');

# Route Resource Film
Route::apiResource('film', 'FilmController');
Route::get('/film-by-id', 'FilmController@getDataById');
Route::get('/film/search/{name}', 'FilmController@search');

# Route Resource Cast
# Method (GET) Search Resource by name
Route::apiResource('cast', 'CastController');
Route::get('/cast/search/{name}', 'CastController@search');

# Route Resource Peran
Route::apiResource('peran', 'PeranController');
Route::get('/peran-by-id', 'PeranController@getDataById');
Route::get('/peran/search/{name}', 'PeranController@search');

# Route Resource Feedback
Route::apiResource('feedback', 'FeedbackController');
Route::get('/feedback-by-id', 'FeedbackController@getDataById');
