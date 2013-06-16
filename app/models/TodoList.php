<?php

class TodoList extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'todo_lists';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	/*
	public function user()
	{
		$this->belongsTo('User');
	}
	*/

}