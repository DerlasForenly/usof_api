<?php

use Illuminate\Support\Facades\Route;

Route::post('/users/avatar', 'App\Http\Controllers\UserController@upload_avatar');
Route::get('/users/{id}/avatar', 'App\Http\Controllers\UserController@download_avatar');


Route::post('/posts/{id}/comments', 'App\Http\Controllers\PostController@create_comment');
Route::get('/posts/{id}/comments', 'App\Http\Controllers\PostController@get_all_comments');
Route::post('/posts/{post_id}/like', 'App\Http\Controllers\PostController@create_like');
Route::delete('/posts/{post_id}/like', 'App\Http\Controllers\PostController@delete_like');
Route::get('/posts/{post_id}/like', 'App\Http\Controllers\PostController@get_all_likes');
Route::get('/posts/{post_id}/categories', 'App\Http\Controllers\PostController@get_categories');

Route::apiResource('posts', 'App\Http\Controllers\PostController');
Route::apiResource('users', 'App\Http\Controllers\UserController');

Route::get('/categories', 'App\Http\Controllers\CategoryController@get_all');
Route::get('/categories/{id}', 'App\Http\Controllers\CategoryController@get_one');
Route::get('/categories/{category_id}/posts', 'App\Http\Controllers\CategoryController@get_all_posts');
Route::post('/categories', 'App\Http\Controllers\CategoryController@create');
Route::patch('/categories/{id}', 'App\Http\Controllers\CategoryController@update');
Route::delete('/categories/{id}', 'App\Http\Controllers\CategoryController@destroy');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'App\Http\Controllers\AuthorizationController@login');
    Route::post('registration', 'App\Http\Controllers\AuthorizationController@registration');
    Route::post('logout', 'App\Http\Controllers\AuthorizationController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthorizationController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthorizationController@me');
    Route::post('password-reset', 'App\Http\Controllers\AuthorizationController@password_reset');
    Route::post('password-reset/{token}', 'App\Http\Controllers\AuthorizationController@token');
});

Route::group([
    'prefix' => 'comments'
], function () {
    Route::get('{id}', 'App\Http\Controllers\CommentController@get');
    Route::get('{id}/like', 'App\Http\Controllers\CommentController@get_likes');
    Route::post('{id}/like', 'App\Http\Controllers\CommentController@create_like');
    Route::patch('{id}', 'App\Http\Controllers\CommentController@update');
    Route::delete('{id}', 'App\Http\Controllers\CommentController@destroy');
    Route::delete('{id}/like', 'App\Http\Controllers\CommentController@delete_like');
});
