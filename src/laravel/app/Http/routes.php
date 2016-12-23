<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');

Route::get('/', 'PostController@index');

Route::get('profil','ProfilController@index');
Route::post('profil','ProfilController@update_avatar');

Route::get('addtrainers','TrainersController@index');
Route::post('addtrainers','TrainersController@update_to_trainer');

Route::get('rmtrainers','TrainersController@indexRemove');
Route::post('rmtrainers','TrainersController@remove_trainer');

Route::get('activate','UserController@getInactive');
Route::post('activate','UserController@activateUser');

Route::get('deleteUser','UserController@getAll');
Route::post('deleteUser','UserController@deleteUser');

Route::get('createGroup','GroupController@index');
Route::post('createGroup','GroupController@create');

Route::get('deleteGroup','GroupController@getToDelete');
Route::post('deleteGroup','GroupController@delete');

Route::get('editGroup','GroupController@getToEdit');
Route::post('editGroup','GroupController@edit');

Route::get('editSelectedGroup','GroupController@getToEdit');
Route::post('editSelectedGroup','GroupController@editSelected');

//Route::post('trainers','TrainersController@remove_trainer');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::resource('running_plan', 'RunningPlanController');

Route::get('diary','DiaryController@index');
Route::post('diary','DiaryController@create');

Route::resource('user_running_plan', 'UserRunningPlanController', ['only' => [
    'store', 'destroy'
]]);