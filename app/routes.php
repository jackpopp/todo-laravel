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

Route::resource('user', 'UserController');
Route::resource('list', 'ListController');


Route::post('auth', array('uses' => 'UserController@auth'));
Route::get('logout', array('uses' => 'UserController@logout'));
Route::get('/', array('uses' => 'HomeController@index'));