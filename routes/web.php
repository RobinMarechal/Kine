<?php

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

use App\Http\Controllers\Controller;

Route::get('/', function () {
	new Controller();
	return view('home');
})
	 ->name('home');

Route::get('a', function () {
	new Controller();
	return view('home');
});

/*
 * Administration routes
 */
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
});

Route::get('admin/development', function () {
	new Controller();
	return view('development');
})
	 ->name('development');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login.showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login.login');
Route::get('logout', 'Auth\LoginController@logout')->name('login.logout');
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('login.redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@callback')->name('login.callback');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register.showRegistrationForm');
Route::post('register', 'Auth\RegisterController@register')->name('register.register');


Route::group(['prefix'=> 'users', 'middleware' => 'auth'], function()
{
	Route::get('notifications', 'UsersController@showNotifications')->name('user.showNotifications');
	Route::get('notifications/all', 'UsersController@showAllNotifications')->name('user.showAllNotifications');
});
