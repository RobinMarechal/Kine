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

Route::get('test', 'MainController@test');

Route::get('/', 'MainController@index')->name('home');

Route::post('update_image', 'MainController@updateImage')->name('updateImage')->middleware('doctor');
Route::post('update_image/undo/{type}', 'MainController@undoImage')->name('undoImage')->middleware('doctor');

Route::get('user', 'ApiController@user')->name('api.user');//->middleware(['doctor', 'ajax']);
Route::get('doctor', 'ApiController@doctor')->name('api.doctor')->middleware('auth');//->middleware(['doctor', 'ajax']);

/*
 * Administration routes
 */
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'Admin\AdminsController@index')->name('admin.index');
    Route::get('utilisateurs', 'Admin\AdminsController@users')->name('admin.users');
    Route::get('contacts', 'Admin\AdminsController@contacts')->name('admin.contacts');
    Route::get('utilisateurs/{id}', 'Admin\AdminsController@showUser')->name('admin.showUser');

    Route::prefix('bugs')->group(function(){
        Route::get('/', 'BugsController@showPending')->name('admin.bugs.showPending');
        Route::get('/resolus', 'BugsController@showSolved')->name('admin.bugs.showSolved');
        Route::get('/tous', 'BugsController@showAll')->name('admin.bugs.showAll');
        Route::get('{id}', 'BugsController@show')->name('admin.bugs.show');
    });
});

Route::get('admin/development', 'MainController@dev')->name('development');
Route::get('connexion', 'Auth\LoginController@showLoginForm')->name('login.showLoginForm');
Route::post('connexion', 'Auth\LoginController@login')->name('login.login');
Route::get('deconnexion', 'Auth\LoginController@logout')->name('login.logout');
Route::get('connexion/facebook', 'Auth\LoginController@redirectToProvider')->name('login.redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@callback')->name('login.callback');
Route::get('inscription', 'Auth\RegisterController@showRegistrationForm')->name('register.showRegistrationForm');
Route::post('inscription', 'Auth\RegisterController@register')->name('register.register');

//Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
Route::get('notifications', 'UsersController@showNotifications')->name('user.showNotifications');
Route::get('notifications/tout-voir', 'UsersController@showAllNotifications')->name('user.showAllNotifications');
//});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'Admin\AdminsController@index')->name('admin.index');
});

Route::prefix("qui-sommes-nous")->group(function () {
    Route::get('/', 'ContactsController@whoAreWe')->name('contacts.whoAreWe');
});

Route::prefix("nos-competences")->group(function () {
    Route::get('/', 'SkillsController@index')->name('skills.index');
});

Route::prefix("news")->group(function () {
    Route::get('/', 'NewsController@index')->name('news.index');
    Route::get('a-venir', 'NewsController@future')->middleware('admin')->name('news.future');
    Route::get('{id}', 'NewsController@show')->name('news.show');
    Route::post('/', 'NewsController@post')->name('news.post')->middleware(['auth', 'doctor']);
});

Route::prefix('articles')->group(function () {
    Route::get('/', 'ArticlesController@index')->name('articles.index');
    Route::get('tag/{tagName}', 'ArticlesController@ofTag')->name('articles.ofTag');
    Route::get('{id}', 'ArticlesController@show')->name('article.show');
    Route::get('rediger', 'ArticlesController@create')->middleware('admin')->name('articles.create');
    Route::post('rediger', 'ArticlesController@store')->middleware('admin')->name('articles.store');
    Route::get('{id}/modifier', 'ArticlesController@edit')->middleware('admin')->name('articles.edit');
    Route::post('{id}/modifier', 'ArticlesController@update')->middleware('admin')->name('articles.update');
    Route::post('previsualisation', 'ArticlesController@preview')->middleware('admin')->name('articles.preview');
});

Route::prefix('cours')->group(function () {
    Route::get('/', 'CoursesController@index')->name('courses.index');
    Route::get('/tag/{tagName}', 'CoursesController@ofTag')->name('courses.ofTag');
});

Route::get('a-propos', 'MainController@about')->name('about');
Route::get('conditions-generales-d-utilisation', 'MainController@cgu')->name('cgu');
Route::get('{any?}', 'MainController@e404')->where('any', '.*')->name('404');