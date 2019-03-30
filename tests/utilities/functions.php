<?php

function create($class, $attributes = [], $quantity = null)
{
    if(isset($quantity)) {
        return factory($class, $quantity)->create($attributes);
    }

    return factory($class)->create($attributes);
}

function make($class, $attributes = [])
{
    return factory($class)->make($attributes);
}