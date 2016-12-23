<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RunningPlan extends Model {

    protected $table = 'running_plans';

    protected $fillable = ['origin', 'destination', 'start', 'end', 'description', 'name', 'owner_id', 'group_id', 'distance_text', 'distance_value', 'origin_lat', 'origin_lng', 'destination_lat', 'destination_lng'];

}
