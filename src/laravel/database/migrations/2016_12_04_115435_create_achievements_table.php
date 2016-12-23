<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('achievements', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->integer('achievement_type_id')->unsigned();
            $table->foreign("achievement_type_id")->references("id")->on("achievement_types")->onDelete('cascade');
            //$table->date('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('achievements');
	}

}
