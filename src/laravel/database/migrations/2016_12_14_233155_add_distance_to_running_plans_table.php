<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDistanceToRunningPlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('running_plans', function(Blueprint $table)
		{
            $table->string('distance_text')->nullable();
            $table->integer('distance_value')->unsigned()->nullable();
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
            $table->dropColumn('distance_text');
            $table->dropColumn('distance_value');
		});
	}

}
