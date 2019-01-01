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

    public function path()
    {
        return '/camps/' . $this->id;
    }

    // TODO: Add camper method?

}
