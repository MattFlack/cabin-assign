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
        return $this->hasMany(Friendship::class);
    }

    public function path()
    {
        return $this->camp->path() . '/campers/' . $this->id;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($camper) {

            // Get friendships when this camper is on either side of the relationship
            $associatedFriendShips = $camper->camp->friendships()
                ->where('friend_id', $camper->id)
                ->orWhere('camper_id', $camper->id)
                ->get();

            $associatedFriendShips->each->delete();
        });
    }

}
