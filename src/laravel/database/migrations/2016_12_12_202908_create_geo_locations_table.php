<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoLocationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_locations', function(Blueprint $table)
        {
            $table->increments('id');

            $table->double('latitude');
            $table->double('longitude');

            $table->integer('running_plan_id')->unsigned();
            $table->foreign("running_plan_id")->references("id")->on("running_plans")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geo_locations');
    }


}
