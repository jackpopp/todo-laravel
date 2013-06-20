<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::filter('auth.basic', function()
{
    return Auth::basic();
});

Route::group( array('before' => 'auth.basic'), function()
{
	Route::resource('list', 'TodoListController');
	Route::resource('todo', 'TodoController');
});

Route::resource('user', 'UserController');

Route::post('auth', array('uses' => 'HomeController@auth'));
Route::get('auth/check', array('uses' => 'HomeController@authCheck'));
Route::get('logout', array('uses' => 'UserController@logout'));
Route::get('/', array('uses' => 'HomeController@index'));