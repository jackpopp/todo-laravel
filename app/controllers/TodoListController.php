<?php

class TodoListController extends BaseController {
	
	/**
	* Show the lists belonging to the logged in user.
	* Eventually add shared lists.
	* @return JSON array.
	**/

	public function index()
	{
		$list = TodoList::with(array('todos' => function($query)
		{
		    $query->where('user_id', '=', Auth::user()->id);
		}))->get()->toArray();
		return Response::json(array('success' => true, 'list' => $list ), 200);
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
			return Response::json(array('success' => true, 'list' => $list->toArray()), 200);
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