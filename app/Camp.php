<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{

    protected $guarded = [];

    public function campers()
    {
        return $this->hasMany(Camper::class);
    }

    public function friendships()
    {
        return $this->hasMany(Friendship::class);
    }

    public function path()
    {
        return '/camps/' . $this->id;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($camp) {
            $camp->campers->each->delete();
        });
    }


    // TODO: Add camper method?

}
