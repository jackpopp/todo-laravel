<?php

class UserController extends BaseController {

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
		echo 'hello';
	}

	public function store()
	{
		$user = new User();
		$user->name = Input::get('name');
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));

		if($user->save())
		{
			return Response::json(array('success' => true, 'user' => $user->toArray()), 200);
		}
		else
		{
			return Response::json(array('success' => false), 500);
		}
	}

	public function show()
	{

	}

	public function edit()
	{

	}

	public function update()
	{

	}

	public function destroy()
	{

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

	public function logout()
	{
		Session::flush();
		return Redirect::to('/');
	}

}