<?php

use Illuminate\Database\Migrations\Migration;

class UpdateListsTablenameToTodolists extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::rename('lists', 'todo_lists');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::rename('todo_lists', 'lists');
	}

}