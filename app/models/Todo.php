<?php

class Todo extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'todos';

	protected $fillable = array('title', 'summary', 'completed');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function todoList()
	{
		return $this->belongsTo('TodoList');
	}

}