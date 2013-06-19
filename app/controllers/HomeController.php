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
	    // get POST data
	    $userdata = array(
	        'username'      => Input::get('username'),
	        'password'      => Input::get('password')
	    );

	    if ( Auth::attempt($userdata) )
	    {
	        // we are now logged in, go to home
	        return Redirect::to('/');
	    }
	    else
	    {
	        // auth failure! lets go back to the login
	        return Redirect::to('auth')
	            ->with('login_errors', true);
	    }
	}

	public function put_user()
	{
		$user = new User();
		$newUser = $user->createUser(Input::get('name'),Input::get('email'),Input::get('password'));

		if($newUser)
		{
			return Response::json(array('success' => true, 'user' => $newUser), 200);
		}
		else
		{
			return Response::json(array('success' => false), 500);
		}
	}

}