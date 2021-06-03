<?php

use Illuminate\Support\Facades\Route;

Route::post('/users/avatar', 'App\Http\Controllers\UserController@upload_avatar');
Route::post('/posts/{id}/comments', 'App\Http\Controllers\PostController@create_comment');
Route::get('/posts/{id}/comments', 'App\Http\Controllers\PostController@get_all_comments');

Route::apiResource('posts', 'App\Http\Controllers\PostController');
Route::apiResource('users', 'App\Http\Controllers\UserController');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'App\Http\Controllers\AuthorizationController@login');
    Route::post('registration', 'App\Http\Controllers\AuthorizationController@registration');
    Route::post('logout', 'App\Http\Controllers\AuthorizationController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthorizationController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthorizationController@me');
    Route::post('password-reset', 'App\Http\Controllers\AuthorizationController@password_reset');
});
