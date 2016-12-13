<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class GeoLocation extends Model {

    protected $table = 'geo_locations';

    protected $fillable = ['latitude', 'longitude', 'running_plan_id'];

    public $timestamps = false;
}
