<?php

use Illuminate\Database\Migrations\Migration;

class AddTableTodoListUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('todo_list_user', function($table)
		{
			$table->increments('id');
			$table->integer('todo_list_id');
			$table->integer('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('todo_list_user');
	}

}