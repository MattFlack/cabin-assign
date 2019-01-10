<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabin extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/camps/' . $this->camp_id . '/cabins/' . $this->id;
    }
}
