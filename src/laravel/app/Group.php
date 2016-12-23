<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    protected $table = 'groups';

    protected $fillable = ['user_id', 'trainer_id', 'name'];

//    public function trainer() {
//        return $this->hasOne('app\User');
//    }
}
