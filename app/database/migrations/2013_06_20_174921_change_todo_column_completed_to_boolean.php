<?php

use Illuminate\Database\Migrations\Migration;

class ChangeTodoColumnCompletedToBoolean extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('todos', function($table)
		{
		    $table->dropColumn('completed');
		});
		Schema::table('todos', function($table)
		{
		    $table->boolean('completed')->default(false);
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
		Schema::table('todos', function($table)
		{
		    $table->dropColumn('completed');
		});
		Schema::table('todos', function($table)
		{
		    $table->integer('completed')->default(0);
		});
	}

}