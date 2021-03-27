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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('events/{event_model}/favorites', 'Api\FavoriteController@toggle');
    Route::post('places/{place_model}/favorites', 'Api\FavoriteController@toggle');
    Route::post('trips/{trip_model}/favorites', 'Api\FavoriteController@toggle');

    Route::post('comments/{comment_model}/ratings', 'Api\RatingController@store');
    Route::post('events/{event_model}/ratings', 'Api\RatingController@store');
    Route::post('places/{place_model}/ratings', 'Api\RatingController@store');
    Route::post('trips/{trip_model}/ratings', 'Api\RatingController@store');
});

Route::resource('events/{event_model}/comments', 'Api\CommentController');
Route::resource('places/{place_model}/comments', 'Api\CommentController');
Route::resource('trips/{trip_model}/comments', 'Api\CommentController');

Route::resource('events', 'Api\EventController');
Route::resource('places', 'Api\PlaceController');
Route::resource('trips', 'Api\TripController');

Route::get('/status', 'Api\ServiceController@status');
