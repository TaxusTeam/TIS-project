<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RunningData extends Model {

    protected $table = 'running_datas';

    protected $fillable = ['user_id', 'user_running_plan_id', 'date', 'mood', 'distance'];

}
