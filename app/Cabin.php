<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabin extends Model
{
    protected $guarded = [];

    protected $withCount = ['campers'];

    public function campers()
    {
        return $this->hasMany(Camper::class);
    }

    public function addCamper(Camper $camper)
    {
        if($this->availableBeds() > 0) {
//            echo "\t\t\t\tAdding $camper->id to cabin $this->id\n";
            $this->campers()->save($camper);
            return true;
        }
//        echo "\t\t\t\tUnable to add $camper->id to cabin $this->id (FULL UP)\n";

        return false;
    }

    public function removeCamper(Camper $camper)
    {
        $camper->cabin()->dissociate();
        $camper->save();
    }

    public function removeAllCampers()
    {
        foreach($this->campers as $camper) {
            $camper->cabin()->dissociate();
            $camper->save();
        }
    }

    public function path()
    {
        return '/camps/' . $this->camp_id . '/cabins/' . $this->id;
    }

    public function availableBeds()
    {
        return $this->number_of_beds - $this->campers->count();
    }
}
