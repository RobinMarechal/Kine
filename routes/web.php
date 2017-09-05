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

Route::get('/', 'MainController@index')
	 ->name('home');


Route::get('user', 'ApiController@user');

/*
 * Administration routes
 */
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
	Route::get('/', 'Admin\AdminsController@index')
		 ->name('admin.index');
	Route::get('utilisateurs', 'Admin\AdminsController@users')
		 ->name('admin.users');
	Route::get('contacts', 'Admin\AdminsController@contacts')
		 ->name('admin.contacts');
});

Route::get('admin/development', 'MainController@dev')
	 ->name('development');

Route::get('connexion', 'Auth\LoginController@showLoginForm')
	 ->name('login.showLoginForm');
Route::post('connexion', 'Auth\LoginController@login')
	 ->name('login.login');
Route::get('deconnexion', 'Auth\LoginController@logout')
	 ->name('login.logout');
Route::get('connexion/facebook', 'Auth\LoginController@redirectToProvider')
	 ->name('login.redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@callback')
	 ->name('login.callback');

Route::get('inscription', 'Auth\RegisterController@showRegistrationForm')
	 ->name('register.showRegistrationForm');
Route::post('inscription', 'Auth\RegisterController@register')
	 ->name('register.register');


//Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
Route::get('notifications', 'UsersController@showNotifications')
	 ->name('user.showNotifications');
Route::get('notifications/tout-voir', 'UsersController@showAllNotifications')
	 ->name('user.showAllNotifications');
//});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
	Route::get('/', 'Admin\AdminsController@index')
		 ->name('admin.index');
});

Route::prefix("qui-sommes-nous")
	 ->group(function () {
		 Route::get('/', 'ContactsController@whoAreWe')
			  ->name('contacts.whoAreWe');
	 });

Route::prefix("nos-competences")
	 ->group(function () {
		 Route::get('/', 'SkillsController@index')
			  ->name('skills.index');
	 });

Route::prefix("news")
	 ->group(function () {
		 Route::get('/', 'NewsController@index')
			  ->name('news.index');

		 Route::get('a-venir', 'NewsController@future')
			  ->middleware('admin')
			  ->name('news.future');

		 Route::get('{id}', 'NewsController@show')
			  ->name('news.show');
	 });


Route::prefix('articles')
	 ->group(function () {
		 Route::get('/', 'ArticlesController@index')
			  ->name('articles.index');
		 Route::get('tag/{tagName}', 'ArticlesController@ofTag')
			  ->name('articles.ofTag');
		 Route::get('{id}', 'ArticlesController@show')
			  ->name('article.show');
		 Route::get('rediger', 'ArticlesController@create')
			  ->name('articles.create');

		 Route::post('rediger', 'ArticlesController@store')
			  ->name('articles.store');

		 Route::get('{id}/modifier', 'ArticlesController@edit')
			  ->name('articles.edit');
		 Route::put('{id}/modifier', 'ArticlesController@update')
			  ->name('articles.update');

		 Route::post('previsualisation', 'ArticlesController@preview')
			  ->name('articles.preview');
	 });


Route::get('{any?}', 'MainController@e404')
	 ->where('any', '.*')
	 ->name('404');