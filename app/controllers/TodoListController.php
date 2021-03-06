<?php

class TodoListController extends BaseController {
	
	/**
	* Show the lists belonging to the logged in user.
	* Eventually add shared lists.
	* @return JSON array.
	**/

	public function index()
	{
		$result = User::with('todoLists', 'todoLists.todos')->where('id', '=', Auth::user()->id)->first()->toArray();
		return Response::json(array('success' => true, 'list' => $result['todo_lists'] ), 200);
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

	public function store()
	{
		$title = Input::get('title');
		$list = new TodoList();
		$list->title = $title;
		$list->user_id = Auth::user()->id;
		$list->shared = 0;
		if ($list->save())
		{
			$list->user()->attach(Auth::user()->id);
			return Response::json(array('success' => true, 'list' => $list->toArray()), 201);
		}
		else
		{
			return Response::json(array('success' => false), 500);
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