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
Route::post('auth', array('uses' => 'UserController@auth'));
Route::get('/', array('uses' => 'HomeController@index'));
//Route::put('user', array('uses' => 'HomeController@user'));
//Route::controller('users', 'UserController');