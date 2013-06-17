<?php

class TodoListController extends BaseController {
	
	/**
	* Show the lists belonging to the logged in user.
	* Eventually add shared lists.
	* @return JSON array.
	**/

	public function index()
	{
		$list = Auth::user()->todoLists()->get();
		Response::json(array('success' => true, 'list' => $list ), 200);
	}

	public function show($id)
	{
		$list = TodoList::find($id);
		if ($list)
		{
			if(Auth::user()->id == $list->user_id)
			{
				return Response::json(array('success'=>true,'list'=>$list), 200);
			}
			else
			{
				return Response::json(array('success' => false, 'message' => 'Not authorised to view list.'), 401);
			}
		}	
		else
		{
			return Response::json(array('success' => false, 'message' => 'Not found.'), 404);
		}
			
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