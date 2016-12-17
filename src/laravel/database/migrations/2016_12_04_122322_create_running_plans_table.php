<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRunningPlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('running_plans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

            //$table->increments('plan_id');
            $table->integer('owner_id')->unsigned();
            $table->foreign("owner_id")->references("id")->on("users")->onDelete('cascade');
            $table->string('origin');
            $table->string('destination');
            $table->date('start');
            $table->date('end');
            $table->longText('description');
            $table->string('name');

            $table->integer('group_id')->unsigned();
            $table->foreign("group_id")->references("id")->on("groups")->onDelete('cascade');

            $table->string('distance_text');
            $table->integer('distance_value')->unsigned();

            $table->double('origin_lat');
            $table->double('origin_lng');

            $table->double('destination_lat');
            $table->double('destination_lng');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('running_plans');
	}

}
