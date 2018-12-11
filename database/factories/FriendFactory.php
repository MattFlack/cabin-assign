<?php

use Faker\Generator as Faker;

$factory->define(App\Friend::class, function (Faker $faker) {
    return [
        'camper_id' => function () {
            return factory('App\Camper')->create()->id;
        },
        'friend_id' => function () {
            return factory('App\Camper')->create()->id;
        }
    ];
});
