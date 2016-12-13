<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

            //$table->integer('user_id')->unsigned();
            //$table->foreign("user_id")->references("id")->on("users");
            $table->string('name');
            $table->integer('trainer_id')->unsigned();
            $table->foreign("trainer_id")->references("id")->on("users");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('groups');
	}

}
