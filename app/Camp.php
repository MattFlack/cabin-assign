<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\ProjectFactory;

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

    public function cabins()
    {
        return $this->hasMany(Cabin::class);
    }

    public function unallocatedCampers()
    {
        return $this->hasMany(Camper::class)->where('cabin_id', null);
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
            $camp->cabins->each->delete();
        });
    }


    public function allocateCabins()
    {
        $this->allocateReciprocatedFriendships();
        $this->refresh();

        $this->allocateCampersWithNoPreferences();

        $this->allocateCampersWithFriendsWhoHaveCabins();
    }

    // Allocates camper/s to specified cabin
    // If no cabin is specified then allocate to first available
    // If pair of campers specified then they need to be allocated to the same cabin
    // Note: The cabin can only be specified for one camper, second camper will be ignored
    private function allocateToCabin(Camper $camper, Camper $friendCamper = null, Cabin $cabin = null)
    {
        $this->refresh();

        if(isset($cabin)) {
            return $cabin->addCamper($camper);
        } else {
            $numBedsRequired = (isset($friendCamper) ? 2 : 1);

            // Fill the cabin with the most available beds first
            $cabin = $this->cabins()->orderByRaw('number_of_beds - campers_count desc')->first();

            if($cabin->availableBeds() >= $numBedsRequired) {
                $cabin->addCamper($camper);

                if(isset($friendCamper)) {
                    $cabin->addCamper($friendCamper);
                }
                return true;
            }

        }
        return false;
    }

    private function allocateReciprocatedFriendships() {

        $cabinAvailability = $this->cabins->mapWithKeys(function ($cabin) {
            return [$cabin->id => $cabin->availableBeds()];
        });

        $allocatedCampers = $this->campers->mapWithKeys(function ($camper) {
            return [$camper->id => $camper->cabin_id];
        });

        foreach ($this->campers as $camper) {
            foreach ($camper->friends as $friend) {

                if($friend->friendOfCamper->friends->contains('friend_id', $camper->id)) {

                    $camperCabinId = $allocatedCampers[$camper->id];
                    $friendCabinId = $allocatedCampers[$friend->friend_id];

                    // Camper has cabin and friend does not
                    if(isset($camperCabinId) && !isset($friendCabinId)) {

                        if($cabinAvailability[$camperCabinId] > 0) {
                            $allocatedCampers[$friend->friend_id] = $camperCabinId;
                            --$cabinAvailability[$camperCabinId];
                        }

                    // Camper without cabin and friend with cabin
                    } elseif(!isset($camperCabinId) && isset($friendCabinId)) {
                        if($cabinAvailability[$friendCabinId] > 0) {
                            $allocatedCampers[$camper->id] = $friendCabinId;
                            --$cabinAvailability[$friendCabinId];
                        }

                    // Both no cabin
                    } elseif(!isset($camperCabinId) && !isset($friendCabinId)) {
                        $emptiestCabinId = $cabinAvailability->sort()->keys()->last();
                        if($cabinAvailability[$emptiestCabinId] > 1) {
                            $allocatedCampers[$camper->id] = $emptiestCabinId;
                            $allocatedCampers[$friend->friend_id] = $emptiestCabinId;
                            $cabinAvailability[$emptiestCabinId] -= 2;
                        }
                    }
                }
            }
        }
        $this->allocateCampers($allocatedCampers);
    }

    private function allocateCampers($campersCabins) {

        foreach ($campersCabins as $camperId => $cabinId) {
            if(isset($cabinId)) {

                $this->cabins->firstWhere('id', $cabinId)
                    ->addCamper($this->campers->firstWhere('id', $camperId));
            }
        }
    }

    private function allocateCampersWithNoPreferences()
    {
        $campers = $this->campers->where('friends_count', 0);

        foreach ($campers as $camper) {
            $this->allocateToCabin($camper);
        }
    }

    private function allocateCampersWithFriendsWhoHaveCabins() {

        $cabinAvailability = $this->cabins->mapWithKeys(function ($cabin) {
            return [$cabin->id => $cabin->availableBeds()];
        })->toArray();

        $allocatedCampers = $this->campers->mapWithKeys(function ($camper) {
            return [$camper->id => $camper->cabin_id];
        });

        $newAllocations = [];
        $camperWasAllocated = true;

        while($camperWasAllocated) {
            $camperWasAllocated = false;

            foreach ($this->campers as $camper) {
                $camperCabinId = $allocatedCampers[$camper->id];

                if (!isset($camperCabinId)) {

                    foreach ($camper->friends as $friendship) {
                        if(!$camperWasAllocated) {
                            $friendCabinId = $allocatedCampers[$friendship->friend_id];

                            if (isset($friendCabinId) && $cabinAvailability[$friendCabinId] > 0) {
                                $allocatedCampers[$camper->id] = $friendCabinId;
                                $newAllocations[$camper->id] = $friendCabinId;
                                --$cabinAvailability[$friendCabinId];
                                $camperWasAllocated = true;
                            }
                        }
                    }
                }
            }
        }
        $this->allocateCampers($newAllocations);
    }

    public function deallocateCabins()
    {
        foreach($this->cabins as $cabin) {
            $cabin->removeAllCampers();
        }
    }

}
