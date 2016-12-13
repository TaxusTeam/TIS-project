<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRunningPlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_running_plans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

            //$table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign("user_id")->references("id")->on("users");
            $table->integer('running_plan_id')->unsigned();
            $table->foreign("running_plan_id")->references("plan_id")->on("running_plan");
            $table->dateTime('start');
            $table->dateTime('finish');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_running_plans');
	}

}
