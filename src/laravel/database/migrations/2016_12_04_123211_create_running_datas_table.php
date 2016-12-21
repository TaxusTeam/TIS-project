<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRunningDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('running_datas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

            //$table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->integer('user_running_plan_id')->unsigned();
            $table->foreign("user_running_plan_id")->references("id")->on("user_running_plan")->onDelete('cascade');
            $table->date('date');
            $table->integer('mood');
            $table->integer('distance')->unsigned(); // do DB v m
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('running_datas');
	}

}
