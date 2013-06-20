<?php

class TodoController extends BaseController {
	
	/**
	* Show the lists belonging to the logged in user.
	* Eventually add shared lists.
	* @return JSON array.
	**/

	public function index()
	{
		$todo = Auth::user()->todos()->get()->toArray();
		return Response::json(array('success' => true, 'todo' => $todo ), 200);
	}

	public function show($id)
	{
		$todo = Todo::find($id);
		if ($todo)
		{
			if(Auth::user()->id == $todo->user_id)
			{
				return Response::json(array('success'=>true,'todo'=>$todo), 200);
			}
			else
			{
				return Response::json(array('success' => false, 'message' => 'Not authorised to view todo.'), 401);
			}
		}	
		else
		{
			return Response::json(array('success' => false, 'message' => 'Not found.'), 404);
		}
			
	}

	public function store()
	{
		$title = Input::get('title');
		$todo = new Todo();
		
		$todo->user_id = Auth::user()->id;
		$todo->todo_list_id = Input::get('todo_list_id');
		$todo->title = Input::get('title');
		$todo->summary = Input::get('summary');

		// Check if the user is allowed to add to this todo list
		if($this->checkAuthorised(Auth::user()->id,Input::get('todo_list_id')))
		{
			if ($todo->save())
			{
				return Response::json(array('success' => true, 'todo' => $todo->toArray()), 200);
			}
			else
			{
				return Response::json(array('success' => false), 500);
			}
		}
		else
		{
			return Response::json(array('success' => false, 'Not authoried to add to this list.'), 401);
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

	private function checkAuthorised($uid,$id)
	{
		$list = TodoList::find($id);
		if ($list)
		{
			if ($list->user_id == $uid)
				return true;
			else
				return false;
		}
		else
		{
			return false;
		}		
	}
}