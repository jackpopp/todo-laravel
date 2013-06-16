<?php

class TodoListController extends BaseController {
	
	/**
	* Show the lists belonging to the logged in user
	**/

	public function index()
	{
		$user = Auth::user();
		print_r($user->todoLists()->get());
	}

	public function show($id)
	{
		echo $id;
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
}