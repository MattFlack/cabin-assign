<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camper extends Model
{
    protected $guarded = [];

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    public function friends()
    {
        return $this->hasMany(Friend::class);
    }

    public function path()
    {
        return $this->camp->path() . '/campers/' . $this->id;
    }

}
