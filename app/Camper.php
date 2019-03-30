<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Camper extends Model
{
    protected $guarded = [];

    protected $withCount = ['friends'];

    public function camp()
    {
        return $this->belongsTo(Camp::class);
    }

    public function friends()
    {
        return $this->hasMany(Friendship::class);
    }

    public function cabin()
    {
        return $this->belongsTo(Cabin::class);
    }

    public function path()
    {
        return $this->camp->path() . '/campers/' . $this->id;
    }

    public function hasCabin()
    {
        return isset($this->cabin_id);
    }

    public function hasFriend()
    {
        if(count($this->friends) === 0) {
            return false;
        }
        return true;
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
