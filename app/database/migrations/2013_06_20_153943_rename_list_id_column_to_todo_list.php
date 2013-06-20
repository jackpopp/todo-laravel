<?php

use Illuminate\Database\Migrations\Migration;

class RenameListIdColumnToTodoList extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('todos', function($table){
			$table->renameColumn('list_id','todo_list_id');
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
		Schema::table('todos', function($table){
			$table->renameColumn('todo_list_id','list_id');
		});
	}

}