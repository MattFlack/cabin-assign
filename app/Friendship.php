<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $guarded = [];

    public function friendOfCamper()
    {
        return $this->belongsTo('App\Camper', 'friend_id');
    }

    public function camper()
    {
        return $this->belongsTo('App\Camper');
    }
}
