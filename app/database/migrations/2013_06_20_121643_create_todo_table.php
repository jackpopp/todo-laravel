<?php

use Illuminate\Database\Migrations\Migration;

class CreateTodoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('todos', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('list_id');
		    $table->string('title');
		    $table->string('summary');
		    $table->integer('completed')->default(0);
		    $table->timestamps();
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
		Schema::drop('todos');
	}

}