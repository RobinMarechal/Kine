<?php

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

Route::post('contents', 'ContentsController@post')->name('contents.post');
Route::put('users/{id}/tags', 'UsersController@updateTags')->name('users.updateTags');

Route::any("{resource}/{id?}/{relation?}/{relatedId?}", 'ApiController@dispatch')->name('api.dispatch');