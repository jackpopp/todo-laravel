<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		return View::make('home.index');
	}

	public function auth()
	{
		$userdata = array(
			'email' => Input::get('email'),
			'password' => Input::get('password')
		);

		if (Auth::attempt($userdata))
		{
			return Response::json(array('success' => true), 200);
		}		
		else
		{
			return Response::json(array('success' => false, 'message' => 'Email or password incorrect'), 500);
		}	
	}

	public function authCheck()
	{
		if(Auth::check())
		{
			return Response::json(array('success' => true), 200);
		}
		else
		{
			return Response::json(array('success' => false),401);
		}
	}

}