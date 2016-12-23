<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AchievementTypes extends Model {

    protected $table = 'achievement_types';

    protected $fillable = ['type'];

    //pridat one-to-many rel.?

}
