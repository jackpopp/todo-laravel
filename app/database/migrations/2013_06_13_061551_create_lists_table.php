<?php

use Illuminate\Database\Migrations\Migration;

class CreateListsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('lists', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
		    $table->string('title');
		    $table->string('shared')->default(0);
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
		Schema::drop('lists');
	}

}