<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupIdToRunningPlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('running_plans', function(Blueprint $table)
		{
            $table->integer('group_id')->unsigned()->nullable();
            $table->foreign("group_id")->references("id")->on("groups")->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('running_plans', function(Blueprint $table)
		{
			$table->dropColumn('group_id');
		});
	}

}
