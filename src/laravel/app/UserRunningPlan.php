<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRunningPlan extends Model {

    protected $table = 'user_running_plans';

    protected $fillable = ['user_id', 'running_plan_id', 'start', 'finnish'];


}
