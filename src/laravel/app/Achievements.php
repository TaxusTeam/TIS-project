<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievements extends Model {

    protected $table = 'achievement_types';

    protected $fillable = ['user_id', 'achievement_id'];

    public function achievementTypes() {
        return $this->belongsTo('app\AchievementTypes');
    }

}
