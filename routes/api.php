<?php

use Illuminate\Http\Request;

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
//Register Login API
Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

//UnAuthenticated Routes
Route::get('post/index', 'API\PostsController@index');
Route::get('post/show/{id}', 'API\PostsController@show');
//Authenticated Routes
Route::group(['middleware' => 'auth:api'], function(){
	Route::get('get-details', 'API\PassportController@getDetails');
	//Posts Controller Below
	Route::post('post/create', 'API\PostsController@store');
	Route::get('post/edit/{id}', 'API\PostsController@edit');
	Route::post('post/update/{id}', 'API\PostsController@update');
	Route::post('post/delete/{id}', 'API\PostsController@destroy');
	//Comments Controller below
	Route::post('post/show/{id}/comment', 'API\CommentsController@store');
	Route::get('comment/edit/{id}', 'API\CommentsController@edit');
	Route::post('comment/update/{id}', 'API\CommentsController@update');
	Route::post('comment/delete/{id}', 'API\CommentsController@destroy');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
